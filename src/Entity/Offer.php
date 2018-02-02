<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="offer")
 * @ApiResource()
 */
class Offer {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $offerId;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $text;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    public function __construct()
    {
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return Offer
     */
    public function setActive($active): Offer
    {
        $this->active = $active;
        return $this;
    }
    /**
     * Get active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
