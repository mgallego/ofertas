<?php

namespace App\FapiRepository;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class MakesRepository.
 */
class MakesRepository
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $clientKey;

    /**
     * @param SessionInterface $session
     * @param Client           $client
     * @param string           $clientKey
     */
    public function __construct(
        SessionInterface $session,
        Client $client,
        string $clientKey
    ) {
        $this->session = $session;
        $this->client = $client;
        $this->clientKey = $clientKey;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $reponse = $this->client->request(
            'GET',
            '/vehicles/ve:car:*?pricedistribution&market=%5Bfuture,onsale%5D&seek=300&k='.$this->clientKey
        );
        $json = json_decode($reponse->getBody(true), true);

        return $json['makes'];
    }
}
