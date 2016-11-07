<?php
/**
 * Created by PhpStorm.
 * User: illepic
 * Date: 11/6/16
 * Time: 7:33 AM
 */

namespace AppBundle\Utils;

use BlizzardApi\BlizzardClient;
use BlizzardApi\Service\WorldOfWarcraft;

class WoWApi
{
    private $wow;

    /**
     * WoWApi constructor.
     * @param String $key
     * @param String $secret
     */
    public function __construct(String $key, String $secret)
    {
        $client = new BlizzardClient($key);
        $this->wow = new WorldOfWarcraft($client->setAccessToken($secret));
    }

    public function getClient() {
        return $this->wow;
    }
}
