<?php
/**
 * Created by PhpStorm.
 * User: illepic
 * Date: 11/6/16
 * Time: 3:19 PM
 */

namespace AppBundle\Utils;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class Character
 * @package AppBundle\Utils
 */
class Character
{

    /**
     * Character name
     * ie 'elapsed'
     *
     * @var string
     */
    public $name;

    /**
     * Realm name
     * ie 'gorgonnash'
     *
     * @var string
     */
    public $realm;

    /**
     * Holds api unserialized data
     * @var
     */
    public $data;

    private $serializer;

    /**
     * Character constructor.
     * @param string $name
     * @param string $realm
     */
    public function __construct(string $name, string $realm)
    {
        $this->name = $name;
        $this->realm = $realm;

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param $data
     */
    public function setData($data)
    {

        $this->data = $this->serializer->deserialize($data, 'json');
    }

    /**
     *
     */
    public function dump()
    {
        return [
            'name' => $this->name,
            'server' => $this->realm
        ];
    }
}
