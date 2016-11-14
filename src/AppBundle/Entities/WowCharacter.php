<?php

namespace AppBundle\Entities;


class WowCharacter implements CharacterInterface {

  private $name;
  private $json;

  public function __construct($json)
  {
    print_r($json);
  }

  public function log()
  {
    return $this->name;
  }

  public function parseJson(Array $data)
  {
    $this->json = $data;
    return $this;
  }
}
