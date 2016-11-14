<?php

namespace AppBundle\Utils;

use AppBundle\Api\WoWApi;
use AppBundle\Entities\CharacterFactory;

/**
 * Class CharacterCreator
 * @package AppBundle\Utils
 */
class CharacterCreator
{

    /**
     * @var
     */
    public $config;

    /**
     * @var array $characters Collection of Character objects
     */
    public $characters = [];

  /**
   * CharacterCreator constructor
   * @param \AppBundle\Api\WoWApi $api
   * @param $config
   */
    public function __construct(WoWApi $api, $config)
    {
        // See /app/config/config.yml:parameters.dfblizz
        $this->config = $config;
        // Init Blizzard client
        $this->wow = $api->getClient();

        // Init Characters
        $this->charactersInit();
        // Hit api and load up character data
//        $this->charactersRetrieve();

        //$fs = new Filesystem();
        //
        //try {
        //    $fs->dumpFile('./test.json', $character_data);
        //}
        //catch(IOException $e) { }
    }

    public function charactersInit()
    {
        // Nuke
        $this->characters = [];
        // From config, set the base data needed for a Character
        foreach ($this->config['characters'] as $config_character) {
          print_r($config_character);
          $response = $this->wow->getCharacter($config_character['realm'], $config_character['name'], [
            'fields' => '',
          ]);
          print_r($response->getBody()->getContents());
//          $this->characters[] = CharacterFactory::get($response->getBody()->getContents());
        }

//        print_r($this->characters);
        return $this;
    }

//    public function charactersRetrieve()
//    {
//        foreach ($this->characters as $character)
//        {
//            print_r($character->name);
//
//            $response = $this->wow->getCharacter($character->realm, $character->name, [
//                'fields' => '',
//            ]);
//            print_r($response->getBody()->getContents());
//            $character->setData($response->getBody()->getContents());
//        }
//    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->characters);
    }

    public function dump()
    {
        print_r($this->characters);
        return $this;
    }
    /**
     * Write out the array of Characters to the filesystem as a json
     */
    public function writeOut()
    {

    }
}
