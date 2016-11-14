<?php

namespace AppBundle\Entities;

/**
 * Interface for all Characters
 *
 * @package AppBundle\Entities
 */
interface CharacterInterface {
    /**
    * Return the name of the Character
    * @return String
    */
    public function log();

    /**
    * Accept raw json, deserialize to real data
    * @param string $data
    * @return mixed
    */
    public function parseJson(String $data);

    public function single(String $key);

    public function all();
}
