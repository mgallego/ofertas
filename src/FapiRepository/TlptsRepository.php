<?php

namespace App\FapiRepository;

use GuzzleHttp\Client;

class TlptsRepository
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $clientKey;

    /**
     * @param Client $client
     * @param string $clientKey
     */
    public function __construct(
        Client $client,
        string $clientKey
    ) {
        $this->client = $client;
        $this->clientKey = $clientKey;
    }

    /**
     * @param int $first
     * @param int $seek
     *
     * @return array
     */
    public function getAll(int $first = 1, int $seek = 20): array
    {
        $reponse = $this->client->request(
            'GET',
            '/vehicles/ve:car:**?market=%5Bonsale%5D&seek='.$seek.'&first='.$first.'&k='.$this->clientKey
        );
        $json = json_decode($reponse->getBody(true), true);

        return $json;
    }
}
