<?php

namespace miamioh\BehatCSVFormatter\Classes;

use miamioh\BehatCSVFormatter\Classes\Scenario;
use Behat\Behat\Tester\Result\StepResult as TestResult;


final class ScenarioRun
{
    /** @var  DateTime */
    private $startTime;

    /** @var  DateTime */
    private $endTime;

    /** @var Scenario */
    private $scenario;

    /** @var String */
    private $duration = '';

    /** @var String */
    private $errorString = '';

    /** @var String */
    private $stepName = '';

    private $status;

    public function __construct(Scenario $scenario, \DateTime $startTime, string $dateTimeFormat = null) {
      $this->scenario = $scenario;
      $this->startTime = $startTime;
      $this->endTime = $startTime;
      if (is_null($dateTimeFormat) ) {
        $this->dateTimeFormat = 'Ymd g:i:s a (e)';
      } else {
        $this->dateTimeFormat = $dateTimeFormat;
      }
      $this->duration = '';
      $this->setStatus(TestResult::UNDEFINED);

    }

    public function getStartTime() : String
    {
      return $this->startTime->format($this->dateTimeFormat);
    }
    public function setEndTime(\DateTime $endTime)
    {
      $this->endTime = $endTime;
    }

    public function getEndTime() : String
    {
      return $this->endTime->format($this->dateTimeFormat);
    }

    public function setDuration(string $duration)
    {
      $this->duration = $duration;
    }

    public function getDuration() : String
    {
      return $this->duration;
    }


    public function asArray() {
      $arrayToReturn = $this->scenario->asArray();
      $arrayToReturn['StartTime'] = $this->getStartTime();
      $arrayToReturn['EndTime'] = $this->getEndTime();
      $arrayToReturn['Duration'] = $this->getDuration();
      $arrayToReturn['Status'] = $this->getStatus();
      $arrayToReturn['StepName'] = $this->getStep();
      $arrayToReturn['ErrorMessage'] = $this->getErrorMessage();

      return $arrayToReturn;
    }
    public function asCSV() {
      return implode(',',$this->asArray());
    }

    public function setStatus($testResults){
      $this->status = $testResults;
    }
    public function getStatus(){
      return array(
          TestResult::PASSED    => 'passed',
          TestResult::SKIPPED   => 'skipped',
          TestResult::PENDING   => 'pending',
          TestResult::FAILED    => 'failed',
          TestResult::UNDEFINED => 'undefined',
          )[$this->status];
    }

    public function setError(string $errorString, string $stepName) {
      $this->setStatus(TestResult::FAILED);
      $this->errorString = $errorString;
      $this->stepName = $stepName;
    }

    public function getStep() : string {
      return $this->stepName;
    }

    public function getErrorMessage(): string {
      return $this->errorString;
    }

}
