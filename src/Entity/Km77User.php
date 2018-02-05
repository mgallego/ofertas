<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class Km77User implements UserInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var array
     */
    private $roles = ['ROLE_USER'];

    /**
     * @param string $uuid
     * @param string $username
     * @param string $email
     * @param string $name
     * @param string $surname
     */
    public function __construct(string $uuid, string $username, string $email, string $name, string $surname)
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->name = $name;
        $this->email = $email;
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function addRoles(array $roles)
    {
        $this->roles = array_merge($this->roles, $roles);
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getPassword()
    {
        //Km77 user implementation has no direct password access.
        return null;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getSalt()
    {
        //Km77 user implementation has no direct salt access.
        return null;
    }

    public function eraseCredentials()
    {
    }
}
