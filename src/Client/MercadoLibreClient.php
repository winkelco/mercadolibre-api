<?php
/*
 * This file is part of the Mercado Libre API client package.
 *
 * (c) Zephia <info@zephia.com.ar>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zephia\MercadoLibre\Client;

use GuzzleHttp\Client as GuzzleClient;
use JMS\Serializer\SerializerInterface;
use Zephia\MercadoLibre\Entity\Category;
use Zephia\MercadoLibre\Entity\Item;
use Zephia\MercadoLibre\Entity\User;

/**
 * Class MercadoLibreClient
 *
 * @package Zephia\MercadoLibre\Client
 * @author  Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
class MercadoLibreClient
{
    // Mercado Libre API URI.
    const BASE_URI = 'https://api.mercadolibre.com';

    /**
     * Guzzle Client
     *
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * Access Token from MercadoLibre OAuth
     *
     * @var string
     */
    private $access_token;

    /**
     * Serializer
     *
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * MercadoLibreClient constructor.
     *
     * @param array $config
     * @param SerializerInterface $serializer
     */
    public function __construct(
        array $config = [],
        SerializerInterface $serializer
    ) {
        $defaults = ['base_uri' => self::BASE_URI];
        $config = array_merge($defaults, $config);

        $this->guzzleClient = new GuzzleClient($config);
        $this->serializer = $serializer;
    }

    /**
     * Get Guzzle client
     *
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }

    /**
     * Set MercadoLibre Access Token
     *
     * @param string $access_token
     *
     * @return $this
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * Get MercadoLibre Access Token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * User show resource
     *
     * @param $customer_id
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function userShow($customer_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/users/' . $customer_id, $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            User::class, 'json'
        );
    }

    /**
     * User show me resource
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function userShowMe()
    {
        return $this->userShow('me');
    }

    /**
     * Category list resource
     *
     * @param $site_id string
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function categoryList($site_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/sites/' . $site_id . '/categories', $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            "array<" . Category::class . ">",
            'json'
        );
    }

    /**
     * Item Show resource
     *
     * @param $item_id
     *
     * @return array|\JMS\Serializer\scalar|object
     */
    public function itemShow($item_id)
    {
        $response = $this->getGuzzleClient()
            ->get('/items/' . $item_id, $this->setQuery());

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            Item::class,
            'json'
        );
    }

    /**
     * Set query
     *
     * @param array $query
     *
     * @return array
     */
    private function setQuery(array $query = [])
    {
        $defaults = [];
        if (!empty($this->getAccessToken())) {
            $defaults['access_token'] = $this->getAccessToken();
        }
        return ['query' => array_merge($defaults, $query)];
    }
}
