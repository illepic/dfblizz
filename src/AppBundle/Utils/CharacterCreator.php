<?php
/**
 * Created by PhpStorm.
 * User: illepic
 * Date: 11/6/16
 * Time: 11:43 AM
 */

namespace AppBundle\Utils;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use AppBundle\Utils\Character;

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
     *
     */
    private $wow;

    /**
     * CharacterCreator constructor.
     * @param \AppBundle\Utils\WoWApi $api
     * @param $config
     */
    public function __construct(WoWApi $api, $config)
    {
        // See /app/config/config.yml:parameters.dfblizz
        $this->config = $config;
        // Init Characters
        $this->charactersInit();

        //$this->wow = $api->getClient();
        //
        //$response = $this->wow->getCharacter('gorgonnash', 'elapsed', [
        //    'fields' => '',
        //]);
        //
        //$character_data = $response->getBody()->getContents();
        //
        //$character = new Character($character_data);
        //$character->dataDump();

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
        foreach ($this->config['characters'] as $character)
        {
            $this->characters[] = new Character($character['name'], $character['server']);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->characters);
    }

    /**
     * Write out the array of Chracters to the filesystem as a json
     */
    public function writeOut()
    {
    }
}
