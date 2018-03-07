<?php

namespace miamioh\BehatCSVFormatter\Formatter;

use Behat\Testwork\Output\Formatter;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Behat\Tester\Result\StepResult as TestResult;
use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Behat\Behat\EventDispatcher\Event\StepTested;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use miamioh\BehatCSVFormatter\Printer\FileOutputPrinter;
use Behat\Testwork\Counter\Timer;
use miamioh\Behat\Classes\Scenario;
use miamioh\Behat\Classes\ScenarioRun;
use miamioh\Behat\Classes\Suite;


/**
 * Class: CSVFormatter
 *
 * @see Formatter
 */
class CSVFormatter implements Formatter
{

      /** @var mixed */
      private $printer;

      /** @var array */
      private $parameters = array();

      /** @var Array */
      private $options = array();

      /** @var ScenarioRun */
      private $currentScenario;

      /** @var Array */
      private $columnList;

      /** @var Suite */
      private $suite;

      /**
       * __construct
       *
       * @param string $filename
       * @param string $outputDir
       * @param string $columnList
       */
      public function __construct(string $filename, string $outputDir, string $columnList, string $delimiter, string $enclosure, string $writeMethod)
      {
          $this->columnList     = explode(',',$columnList);
          $this->options['delimiter']      = $delimiter;
          $this->options['enclosure']      = $enclosure;
          $this->options['writeMethod']    = substr(strtoupper($writeMethod),0,1);
          $this->printer        = new FileOutputPrinter($filename, $outputDir, $this->options);
          $this->testcaseTimer  = new Timer();

          if ($this->options['writeMethod'] == 'O') {
            $this->printer->writeHeaderRow($this->columnList);
          }
      }

      /**
       * {@inheritDoc}
       */
      public function getName()
      {
          return 'CSVFormatter';
      }

      /**
       * {@inheritDoc}
       */
      public function getDescription()
      {
          return 'Creates a CSV file';
      }

      /**
       * {@inheritDoc}
       */
      public function setParameter($name, $value)
      {
          $this->parameters[$name] = $value;
      }

      /**
       * {@inheritDoc}
       */
      public function getParameter($name)
      {
          return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
      }

      /**
       * getOutputPrinter
       *
       * @return OutputPrinter
       */
      public function getOutputPrinter()
      {
          return $this->printer;
      }

      /**
       * {@inheritDoc}
       */
      public static function getSubscribedEvents()
      {
        return array(
              ScenarioTested::BEFORE  => array('beforeScenario', -50),
              ScenarioTested::AFTER   => array('afterScenario', -50),
              StepTested::AFTER       => array('afterStep', -50),
        );
      }

      /**
       * beforeScenario
       *
       * @param ScenarioTested $event
       *
       * @return void
       */
      public function beforeScenario(ScenarioTested $event)
      {
        $tags = array_merge($event->getFeature()->getTags(),$event->getScenario()->getTags());
        $scenario = new Scenario($event->getScenario()->getTitle(),$tags,[],null,null);
        $this->currentScenario = new ScenarioRun($scenario,new \DateTime());
        $this->suite = new Suite($event->getSuite()->getName());
        $this->testcaseTimer->start();
      }

      /**
       * afterStep
       *
       * @param mixed $event
       */
      public function afterStep($event)
      {
          $code = $event->getTestResult()->getResultCode();
          if(TestResult::FAILED === $code) {
              if ($event->getTestResult()->hasException()) {
                $stepInfo = $event->getStep()->getKeyword() . " " . $event->getStep()->getText();
                $errorMessage = $event->getTestResult()->getException()->getMessage();
                $this->currentScenario->setError($errorMessage,$stepInfo);
              }
            }
      }

      /**
       * afterScenario
       *
       * @param mixed $event
       */
      public function afterScenario($event)
      {
          $this->testcaseTimer->stop();
          $this->currentScenario->setEndTime(new \DateTime());
          $this->currentScenario->setDuration($this->testcaseTimer);
          $this->currentScenario->setStatus($event->getTestResult()->getResultCode());
          $this->printer->write($this->generateOutputColumns(),$this->options);
      }

      private function generateOutputColumns() {
        $possibleColumns = array_change_key_case(array_merge(['suite'=>$this->suite->getName()],$this->currentScenario->asArray()),CASE_UPPER);
        $outputColumns = [];
        foreach($this->columnList as $column) {
          $outputColumns[] = $possibleColumns[strtoupper($column)];
        }
        return $outputColumns;
        // $this->columnList();
      }
}
