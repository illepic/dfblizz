<?php

namespace AppBundle\Utils;

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
     * CharacterCreator constructor
     * @param \AppBundle\Utils\CharacterManager $manager
     * @param array $config
     */
    public function __construct(CharacterManager $manager, Array $config)
    {
        // See /app/config/config.yml:parameters.dfblizz
        $this->config = $config;

        // Init Characters
        $manager->retrieveAllCharacters($this->config['characters']);

        // Write all characters to json file
        //$this->toJson();
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
