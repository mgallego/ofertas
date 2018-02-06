<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    public $userId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $username;

    /**
     * @ORM\Column(type="simple_array", length=255, name="make_slugs")
     */
    public $makeSlugs;

    public function __construct()
    {
        $this->makeSlugs = new ArrayCollection();
    }
}