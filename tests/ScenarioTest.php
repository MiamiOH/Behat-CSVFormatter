<?php
use miamioh\BehatCSVFormatter\Classes\Scenario;
use PHPUnit\Framework\TestCase;

class ScenarioTests extends TestCase {

private $scenario;

  public function testCannotCreateWithoutAName(): void {
    $this->expectException(ArgumentCountError::class);
    $this->scenario = new Scenario();
  }

  public function testCanBeUsedAsString(): void {
    $this->assertEquals('Test Form', new Scenario('Test Form'));
  }

  public function testCanBeUsedAsArray(): void {
    $this->scenario = new Scenario('Test Form');
    $this->assertEquals(['Name'=>'Test Form'], $this->scenario->asArray());
  }

  public function testTagsCanBeRetrieved(): void {
    $this->scenario = new Scenario('Test Form');
    $tags = array('@testTag');
    $this->scenario->setTags($tags);
    $this->assertEquals($tags,$this->scenario->getTags());
  }

  // public function testCanBeUsedAsCSV(): void {
  //   $this->scenario = new Scenario('Test Form');
  //   $tags = array('@testTag');
  //   $this->scenario->setTags($tags);
  //   $this->assertEquals(implode)
  // }




}
