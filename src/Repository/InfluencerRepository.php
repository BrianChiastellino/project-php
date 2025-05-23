<?php

namespace App\Repository;

use App\Entity\Influencer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Influencer>
 *
 * @method Influencer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Influencer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Influencer[]    findAll()
 * @method Influencer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfluencerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Influencer::class);
    }

//    /**
//     * @return Influencer[] Returns an array of Influencer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Influencer
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
