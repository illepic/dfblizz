<?php

namespace AppBundle\Entities;

class CharacterFactory {

    /**
     * @param String $json
     * @return \AppBundle\Entities\WowCharacter
     */
    static public function get(String $json)
    {
        return new WowCharacter($json);
    }
}
