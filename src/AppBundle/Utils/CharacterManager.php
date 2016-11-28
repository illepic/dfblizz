<?php

namespace AppBundle\Utils;


use AppBundle\Api\WoWApi;
use AppBundle\Entities\CharacterFactory;
use AppBundle\Entities\WowCharacter;
use AppBundle\Process\ProcessCharacter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CharacterManager
{

    private $characters = [];
    //private $wowapi;

    /**
     * CharacterManager constructor.
     * @param \AppBundle\Api\WoWApi $api
     * @param \AppBundle\Process\ProcessCharacter $process
     */
    public function __construct(WoWApi $api, ProcessCharacter $process)
    {
        // Init Blizzard client
        $this->wowapi = $api->getClient();
        $this->process = $process;
    }

    /**
     * Lookup a character by name + realm, return raw json string
     *
     * @param String $realm
     * @param String $name
     * @return string
     */
    public function lookupCharacter(String $realm, String $name, Array $fields)
    {
        $response = $this->wowapi->getCharacter(
            $realm,
            $name,
            ['fields' => implode(',', $fields)] // fields here
        ); // @TODO: fields

        if (200 === $response->getStatusCode()) {
            return (String)$response->getBody()->getContents();
        } else {
            throw new NotFoundHttpException('Character not found!');
        }
    }

    /**
     * Take config array of characters and use wowapi to find each
     * Array looks like:
     *  array(
     *      'characters' => array(
     *          array('name' => 'Elapsed', 'race' => 3),
     *          array('name' => 'Taldoor', 'race' => 3,
     *      )
     *  );
     *
     * @param array $characters
     * @return $this
     */
    public function retrieveAllCharacters(Array $characters)
    {
        foreach ($characters as $character_info) {
            // json
            $raw = $this->lookupCharacter(
                $character_info['realm'],
                $character_info['name'],
                $character_info['fields'] // array
            );

            // Character object
            $character = CharacterFactory::get($raw);

            // Run the character data through a process to remove cruft
            $character->modify($this->process);

            // Add to local array
            $this->characters[] = $character;

            // Simple notification
            echo("{$character->single('name')} retrieved successfully!".PHP_EOL);
        }

        return $this;
    }

    /**
     * Return raw array
     *
     * @return array
     */
    public function getAllCharacters()
    {
        return $this->characters;
    }

    /**
     * Return count of total characters
     *
     * @return int
     */
    public function getCharactersCount()
    {
        return count($this->characters);
    }

    /**
     * Dump json of all characters
     * @return string
     */
    public function dumpCharactersJson()
    {
        return json_encode(
            array_map(
                function (WowCharacter $character) {
                    return $character->all();
                },
                $this->characters,
                []
            )
        );
    }
}
