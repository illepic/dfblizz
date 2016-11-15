<?php

namespace AppBundle\Api;

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

    /**
     * @return \BlizzardApi\Service\WorldOfWarcraft
     */
    public function getClient() {
        return $this->wow;
    }
}
