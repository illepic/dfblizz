<?php

namespace AppBundle\Entities;

class CharacterFactory {

    static public function get(String $json)
    {
        return new WowCharacter($json);
    }
}
