<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tlpt")
 * @ApiResource()
 */
class Tlpt
{
    /**
     * @var string
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    private $nql;

    private $offersIncludedIn;

    private $offersExcludedIn;

    private $offersUnassigned;

    public function __construct()
    {
        $this->offersIncludedIn = new ArrayCollection();
        $this->offersExcludedIn = new ArrayCollection();
        $this->offersUnassigned = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->nql;
    }
}
