<?php

namespace App\Oauth;

use App\Entity\Km77User;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Km77OauthUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var string
     */
    const ACCESS_TOKEN_SESSION_KEY = 'user_access_token';

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
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Km77OauthUserProvider constructor.
     * @param SessionInterface $session
     * @param Client $client
     * @param EntityManager $entityManager
     * @param string $clientKey
     */
    public function __construct(
        SessionInterface $session,
        Client $client,
        EntityManager $entityManager,
        string $clientKey
    ) {
        $this->session = $session;
        $this->client = $client;
        $this->clientKey = $clientKey;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $username
     *
     * @return Km77User
     */
    public function loadUserByUsername($username): Km77User
    {
        $accessToken = $this->session->get(self::ACCESS_TOKEN_SESSION_KEY);
        $options = [];
        $options['headers']['Authorization'] = 'Bearer '.$accessToken;
        $reponse = $this->client->request('GET', '/users/me?k='.$this->clientKey, $options);
        $json = json_decode($reponse->getBody(true), true);
        $km77User = new Km77User(
            $json['uuid'],
            $json['username'],
            $json['email'],
            $json['name'],
            $json['surname']
        );

        $user = $this->findUser($km77User);
        if (!empty($user)) {
            $this->session->set('make_slugs', $user->makeSlugs);
            $km77User->addRoles(['ROLE_ADMIN', 'ROLE_SONATA_ADMIN']);
        }

        return $km77User;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return Km77User
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): Km77User
    {
        $this->session->set(self::ACCESS_TOKEN_SESSION_KEY, $response->getAccessToken());

        return $this->loadUserByUsername($response->getNickname());
    }

    /**
     * @param UserInterface $user
     *
     * @return Km77User
     */
    public function refreshUser(UserInterface $user): Km77User
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return $class === Km77User::class;
    }

    /**
     * @param Km77User $km77User
     * @return User|null
     */
    private function findUser(Km77User $km77User): ?User
    {
        return $this->entityManager->getRepository('App\Entity\User')->findOneByUsername($km77User->getUsername());
    }
}
