<?php

use Behat\Behat\Tester\Result\StepResult as TestResult;
use PHPUnit\Framework\TestCase;

class ScenarioRunTests extends TestCase {

  /** @var ScenarioRun */
  private $scenarioRun;

  /** @var  Scenario */
  private $scenario;

  private $dateTimeFormat = 'Ymd g:i:s a (e)';

  public function setUp(): void
  {
      $this->scenario = new Scenario('Test Scenario');
      $this->dateTimeFormat = 'Ymd g:i:s a';
  }

  public function testCannotCreateScenarioRunWithoutScenario(): void {
    $this->expectException(ArgumentCountError::class);
    $this->scenarioRun = new ScenarioRun();
  }

  public function testCannotCreateScenarioRunWithoutStartTime(): void {
    $this->expectException(ArgumentCountError::class);
    $this->scenarioRun = new ScenarioRun($this->scenario);

  }

  public function testFormattedStartTimeCanBeReturned(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->assertEquals($today->format($this->dateTimeFormat),$this->scenarioRun->getStartTime());
  }

  public function testCanBeUsedAsArray(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $resultsArray = [
      'Name'=>'Test Scenario',
      'Tags'=>'',
      'StartTime'=>$today->format($this->dateTimeFormat),
      'EndTime'=>$today->format($this->dateTimeFormat),
      'Duration'=>'',
      'Status'=>'undefined',
      'StepName' => '',
      'ErrorMessage' => ''

    ];
    $this->assertEquals($resultsArray, $this->scenarioRun->asArray());
  }

  public function testCanBeUsedAsCSVString(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->assertEquals(implode(',',$this->scenarioRun->asArray()), $this->scenarioRun->asCSV());
  }

  public function testEndTimeCanBeReturned(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->scenarioRun->setEndTime($today);
    $this->assertEquals($today->format($this->dateTimeFormat),$this->scenarioRun->getEndTime());
  }

  public function testRunTimeCanBeReturned(): void {
    $today = new DateTime();
    $sampleDuration = '8.87';
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->scenarioRun->setEndTime($today);
    $this->scenarioRun->setDuration($sampleDuration);
    $this->assertEquals($sampleDuration, $this->scenarioRun->getDuration());
  }

  public function testTestStatusCanBeReturned(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->scenarioRun->setStatus(TestResult::PASSED);
    $this->assertEquals('passed', $this->scenarioRun->getStatus());
  }

  public function testErrorMessageCanBeReturned(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->scenarioRun->setError('There was a problem','Then I should not see an ERROR');
    $this->assertEquals('Then I should not see an ERROR', $this->scenarioRun->getStep());
    $this->assertEquals('There was a problem', $this->scenarioRun->getErrorMessage());
  }
  public function testScenarioFailsWhenErrorMessageSet(): void {
    $today = new DateTime();
    $this->scenarioRun = new ScenarioRun($this->scenario,$today);
    $this->scenarioRun->setError('There was a problem','Then I should not see an ERROR');
    $this->assertEquals('failed', $this->scenarioRun->getStatus());
  }


}
