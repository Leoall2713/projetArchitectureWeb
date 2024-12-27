<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservations>
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    //    /**
    //     * @return Reservations[] Returns an array of Reservations objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservations
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
     * Filtre les réservations en fonction de la promotion et de la salle.
     *
     * @param Promotions|null $promotion
     * @param Salles|null $salle
     * @return Reservations[]
     */
    public function findByFilters($promotion = null, $salle = null)
    {
        $qb = $this->createQueryBuilder('r');

        if ($promotion) {
            $qb->andWhere('r.promotion = :promotion')
               ->setParameter('promotion', $promotion);
        }

        if ($salle) {
            $qb->andWhere('r.salle = :salle')
               ->setParameter('salle', $salle);
        }

        return $qb->getQuery()->getResult();
    }

}
