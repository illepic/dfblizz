<?php

namespace AppBundle\Utils;


use AppBundle\Api\WoWApi;
use AppBundle\Entities\CharacterFactory;
use AppBundle\Entities\WowCharacter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CharacterManager
{

    private $characters = [];
    private $wow;

    /**
     * CharacterManager constructor.
     * @param \AppBundle\Api\WoWApi $api
     * @param array $config
     */
    public function __construct(WoWApi $api, Array $config)
    {
        // Init Blizzard client
        $this->wow = $api->getClient();
        // Retrieve
        //$this->retrieveAllCharacters($config['characters']);

        print_r($this->characters[2]->single('name'));
    }

    /**
     * Lookup a character by name + realm, return raw json string
     *
     * @param String $realm
     * @param String $name
     * @return string
     */
    public function lookupCharacter(String $realm, String $name)
    {
        $response = $this->wow->getCharacter(
            $realm,
            $name,
            []
        ); // @TODO: fields

        if (200 === $response->getStatusCode()) {
            return (String)$response->getBody()->getContents();
        } else {
            throw new NotFoundHttpException('Character not found!');
        }
    }

    /**
     * Use CharacterFactory to make a Character object
     *
     * @param String $json
     * @return \AppBundle\Entities\WowCharacter
     */
    public function createCharacter(String $json)
    {
        return CharacterFactory::get($json);
    }

    /**
     * Add Character to local array
     *
     * @param \AppBundle\Entities\WowCharacter $character
     */
    public function addCharacter(WowCharacter $character)
    {
        $this->characters[] = $character;
    }

    public function retrieveAllCharacters(Array $characters)
    {
        foreach ($characters as $character_info) {
            // json
            $raw = $this->lookupCharacter(
                $character_info['realm'],
                $character_info['name']
            );
            // Character object
            $character = $this->createCharacter($raw);
            // Add to local array
            $this->addCharacter($character);
        }

        return $this;
    }
}
