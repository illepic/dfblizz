<?php

namespace AppBundle\Utils;

use AppBundle\Api\WoWApi;
use AppBundle\Entities\CharacterFactory;
use AppBundle\Entities\WowCharacter;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

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

        // Write all characters to json file
        $this->toJson();
    }

    public function charactersInit()
    {
        // Nuke
        $this->characters = [];
        // From config, set the base data needed for a Character
        foreach ($this->config['characters'] as $config_character) {
            echo "Requesting {$config_character['name']}".PHP_EOL;

            $response = $this->wow->getCharacter(
                $config_character['realm'],
                $config_character['name'],
                [
                    'fields' => implode(',', $this->config['fields']),
                ]
            );

            $status = $response->getStatusCode();
            if ($status === 200) {
                $character = CharacterFactory::get(
                    $response->getBody()->getContents()
                );
                $this->characters[] = $character;
                echo "{$character->single('name')} created!".PHP_EOL;
            } else {
                echo "Failed! Response: $status.".PHP_EOL;
            }
        }

        print_r($this->characters[0]->single('name'));

        return $this;
    }

    public function toJson()
    {
        /**
         * e.g.
         * array(
         *      'characters' => array(
         *          array('name' => 'Elapsed', 'race' => 3),
         *          array('name' => 'Taldoor', 'race' => 3,
         *      )
         * );
         */
        $out = array(
            $this->config['top_key'] => array_map(
                function (WowCharacter $character) {
                    return $character->all();
                },
                $this->characters
            ),
        );

        $fs = new Filesystem();
        try {
            $fs->dumpFile(
                $this->config['output_dir'].'characters.json',
                json_encode($out)
            );
        } catch (IOException $e) {
        }
    }

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
}
