<?php
use PHPUnit\Framework\TestCase;

class ScenarioTests extends TestCase {

  private $scenario;

  public function testCanBeUsedAsString(): void {
    $this->assertEquals('Test Form', new Scenario('Test Form'));
  }

  public function testCannotCreateWithoutAName(): void {
    $this->expectException(ArgumentCountError::class);
    $this->scenario = new Scenario();
  }


  public function testCanBeUsedAsArray(): void {
    $this->scenario = new Scenario('Test Form');
    $this->assertEquals(['Name'=>'Test Form','Tags'=>''], $this->scenario->asArray());
  }

  public function testTagsCanBeRetrieved(): void {
    $tags = array('@testTag');
    $this->scenario = new Scenario('Test Form',$tags);
    $this->assertEquals($tags,$this->scenario->getTags());
  }

  public function testCanBeUsedAsCSVwith1Tag(): void {
    $tags = array('@testTag');
    $this->scenario = new Scenario('Test Form',$tags);
    $this->assertEquals(['Name'=>'Test Form','Tags'=>'@testTag'],$this->scenario->asArray());
  }
  public function testCanBeUsedAsCSVwith2Tags(): void {
    $tags = array('@testTag','test2');
    $this->scenario = new Scenario('Test Form',$tags);
    $this->assertEquals(['Name'=>'Test Form','Tags'=>'@testTag,test2'],$this->scenario->asArray());
  }


}
