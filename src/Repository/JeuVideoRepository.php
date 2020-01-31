<?php

namespace App\Repository;

use App\Entity\JeuVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JeuVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method JeuVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method JeuVideo[]    findAll()
 * @method JeuVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JeuVideo::class);
    }

    // /**
    //  * @return JeuVideo[] Returns an array of JeuVideo objects
    //  */

    public function findHome($limit)
    {
        return $this->createQueryBuilder('j')
            ->orderBy('j.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return JeuVideo[] Returns an array of JeuVideo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JeuVideo
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
