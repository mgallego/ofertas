<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\Tlpt;
use App\Entity\Offer;

class AssignTlptToOffer
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tlpt) {
            return;
        }

        $nql = explode(':', $entity->nql);
        $make = $nql[2];
        $model = $nql[3];

        $entityManager = $args->getEntityManager();
        $offers = $entityManager->getRepository(Offer::class)->findBy(['makeSlug' => $make, 'model' => $model]);

        foreach ($offers as $offer) {
            $offerNql = 've:car:'.$offer->makeSlug.':'.$offer->model;
            if (!empty($offer->modelYear)) {
                $offerNql .= ':'.$offer->modelYear;
            }
            if (strpos($entity->nql, $offerNql) === false) {
                continue;
            }

            $offer->appendUnassignedTlpt($entity);
            $entityManager->persist($offer);
        }
        $entityManager->flush();
    }
}
