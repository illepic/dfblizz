<?php
/**
 * Created by PhpStorm.
 * User: illepic
 * Date: 11/6/16
 * Time: 3:19 PM
 */

namespace AppBundle\Utils;


/**
 * Class Character
 * @package AppBundle\Utils
 */
/**
 * Class Character
 * @package AppBundle\Utils
 */
class Character
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $server;

    /**
     * Character constructor.
     */
    public function __construct(string $name, string $server)
    {
        $this->name = $name;
        $this->server = $server;
    }

    /**
     *
     */
    public function dump()
    {
        return [
            'name' => $this->name,
            'server' => $this->server
        ];
    }
}
