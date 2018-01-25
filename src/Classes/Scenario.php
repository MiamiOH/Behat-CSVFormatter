<?php

use Behat\Gherkin\Node\ScenarioNode;

class Scenario extends ScenarioNode
{

  public function __construct(string $title, array $tags = [], array $steps = [], $keyword = null, $line = null) {
    parent::__construct($title,$tags,$steps,$keyword,$line);

  }

  public function __toString(): string
  {
      return $this->getTitle();
  }
  public function asArray(): array
  {
    return array('Name'=>$this->getTitle(),'Tags'=>$this->getTagsAsString());
  }

  public function setTags(array $tags) {
    $this->tags = $tags;
  }

  public function getTagsAsString() {
    return implode(',',$this->getTags());
  }

}
