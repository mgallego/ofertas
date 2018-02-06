<?php

namespace App\Manager;

use App\Entity\Tlpt;
use App\FapiRepository\TlptsRepository;
use Doctrine\ORM\EntityManager;

class TlptManager
{
    const SEEK = 20;
    private $makesRepository;

    private $entityManager;

    public function __construct(TlptsRepository $tlptsRepository, EntityManager $entityManager)
    {
        $this->makesRepository = $tlptsRepository;
        $this->entityManager = $entityManager;
    }

    public function dumpAll(\Closure $callback = null)
    {
        $hasMorePages = true;
        $first = 1;

        while ($hasMorePages) {
            $tlptsResponse = $this->makesRepository->getAll($first, self::SEEK);

            $tlpts = $tlptsResponse['tlpts'];

            if (count($tlpts) < self::SEEK) {
                $hasMorePages = false;
            }

            $first += self::SEEK;

            $this->insertOrUpdateInDb($callback, $tlptsResponse);

            $this->entityManager->flush();
        }
    }

    /**
     * @param \Closure $callback
     * @param $tlpts
     *
     * @throws \Doctrine\ORM\ORMException
     */
    private function insertOrUpdateInDb(\Closure $callback, $tlptsResponse)
    {
        $tlptsNumber = $tlptsResponse['numtotal'];
        $tlptsFirst = $tlptsResponse['numfirst'];
        $tlpts = $tlptsResponse['tlpts'];

        $i = 0;

        foreach ($tlpts as $tlpt) {
            $dbTlpt = $this->entityManager->getRepository(Tlpt::class)->findOneByNql($tlpt['nql']);

            if (null == $dbTlpt) {
                $dbTlpt = new Tlpt();
                $dbTlpt->nql = $tlpt['nql'];
            }
            if ($callback) {
                $callback($tlptsFirst + $i, $tlptsNumber, $tlpt['name']);
            }

            $dbTlpt->name = $tlpt['name'];
            $dbTlpt->fullName = $tlpt['fullname'];

            $this->entityManager->persist($dbTlpt);
            ++$i;
        }
    }
}
