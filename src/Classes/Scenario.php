<?php

namespace miamioh\BehatCSVFormatter\Classes;

final class Scenario
{
    /** @var  string */
    private $name;

    /** @var  Array */
    private $tags;


    public function __construct(string $name)
    {
        $this->name = $name;
        $this->tags = [];
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function asArray(): array
    {
      return array('Name'=>$this->name);
    }

    public function setTags(array $tags) {
      $this->tags = $tags;
    }

    public function getTags() {
      return $this->tags;
    }

}
