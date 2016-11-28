<?php

namespace AppBundle\Entities;

class WowCharacter implements CharacterInterface
{
    private $data;

    public function __construct(String $json)
    {
        $this->parseJson($json);
    }

    public function log()
    {
        return $this->data;
    }

    /**
     * @param String $json
     * @return $this
     * @internal param String $data, json string to turn into array on object here
     */
    public function parseJson(String $json)
    {
        $this->data = json_decode($json, true);

        return $this;
    }

    /**
     * Pull a single value from a Character
     *
     * @param String $key
     * @return mixed
     */
    public function single(String $key)
    {
        return $this->data[$key];
    }


    /**
     * Dump all data from Character raw
     *
     * @return mixed
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Dump this data as json
     * @return string
     */
    public function dumpJson()
    {
        return json_encode($this->data);
    }

}
