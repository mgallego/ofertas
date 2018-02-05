<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="string", length=255, name="make_slug")
     */
    public $makeSlug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $model;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    public $modelYear;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * @ORM\ManyToMany(targetEntity="Tlpt", inversedBy="offers")
     * @ORM\JoinTable(name="offers_tlpts_included",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="offer_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tlpt_nql", referencedColumnName="nql")}
     *      )
     */
    public $includedTlpts;

    /**
     * @ORM\ManyToMany(targetEntity="Tlpt", inversedBy="offers")
     * @ORM\JoinTable(name="offers_tlpts_excluded",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="offer_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tlpt_nql", referencedColumnName="nql")}
     *      )
     */
    public $excludedTlpts;

    /**
     * @ORM\ManyToMany(targetEntity="Tlpt", inversedBy="offers")
     * @ORM\JoinTable(name="offers_tlpts_unassigned",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="offer_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tlpt_nql", referencedColumnName="nql")}
     *      )
     */
    public $unassignedTlpts;

    public function __construct() {
        $this->includedTlpts = new ArrayCollection();
        $this->excludedTlpts = new ArrayCollection();
        $this->unassignedTlpts = new ArrayCollection();
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
