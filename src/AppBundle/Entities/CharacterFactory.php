<?php

namespace AppBundle\Entities;

class CharacterFactory {

  static public function get(String $json)
  {
    $instance = new WowCharacter($json);
    return $instance;
  }
}
