<?php

namespace App\Manager;

use App\Entity\Make;
use App\FapiRepository\MakesRepository;
use Doctrine\ORM\EntityManager;

class MakeManager
{
    private $makesRepository;

    private $entityManager;

    public function __construct(MakesRepository $makesRepository, EntityManager $entityManager)
    {
        $this->makesRepository = $makesRepository;
        $this->entityManager = $entityManager;
    }

    public function dumpAll(\Closure $callback = null)
    {
        $makelist = $this->makesRepository->getAll();

        foreach ($makelist as $make) {
            $dbMake = $this->entityManager->getRepository(Make::class)->findOneByNql($make['nql']);

            if (null == $dbMake) {
                $dbMake = new Make();
                $dbMake->nql = $make['nql'];
            }
            if ($callback) {
                $callback($make['name']);
            }

            $dbMake->name = $make['name'];
            $dbMake->makeSlug = $make['slug'];

            $this->entityManager->persist($dbMake);
        }

        $this->entityManager->flush();
    }
}
