<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="make")
 */
class Make
{
    /**
     * @var string
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    public $nql;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="make_slug")
     */
    public $makeSlug;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $name;
}
