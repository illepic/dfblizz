<?php

namespace AppBundle\Utils;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class CharacterCreator
 * @package AppBundle\Utils
 */
class CharacterCreator
{

    public $config;
    public $manager;

    /**
     * CharacterCreator constructor
     * @param \AppBundle\Utils\CharacterManager $manager
     * @param array $config
     */
    public function __construct(CharacterManager $manager, Array $config)
    {
        // See /app/config/config.yml:parameters.dfblizz
        $this->config = $config;

        // Using CharacterManger
        $this->manager = $manager;

        // Init Characters
        $this->manager->retrieveAllCharacters($this->config['characters']);

        // Write all characters to json file
        $this->writeJson();
    }

    /**
     * Write out any Characters from the manger to the directory from config
     */
    public function writeJson()
    {
        $fs = new Filesystem();
        try {
            $fs->dumpFile(
                $this->config['output_dir'].'characters.json',
                $this->manager->dumpCharactersJson()
            );
        } catch (IOException $e) {
        }
    }

    public function dump()
    {
        print_r($this->manager->getAllCharacters());

        return $this;
    }
}
