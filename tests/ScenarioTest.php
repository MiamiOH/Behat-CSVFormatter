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
    $this->assertEquals(['Name'=>'Test Form','Tags'=>''], $this->scenario->asArray());
  }

  public function testTagsCanBeRetrieved(): void {
    $this->scenario = new Scenario('Test Form');
    $tags = array('@testTag');
    $this->scenario->setTags($tags);
    $this->assertEquals($tags,$this->scenario->getTags());
  }

  public function testCanBeUsedAsCSVwith1Tag(): void {
    $this->scenario = new Scenario('Test Form');
    $tags = array('@testTag');
    $this->scenario->setTags($tags);
    $this->assertEquals(['Name'=>'Test Form','Tags'=>'@testTag'],$this->scenario->asArray());
  }
  public function testCanBeUsedAsCSVwith2Tags(): void {
    $this->scenario = new Scenario('Test Form');
    $tags = array('@testTag','test2');
    $this->scenario->setTags($tags);
    $this->assertEquals(['Name'=>'Test Form','Tags'=>'@testTag,test2'],$this->scenario->asArray());
  }




}
