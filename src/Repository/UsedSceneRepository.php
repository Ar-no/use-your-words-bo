<?php

namespace App\Repository;

use App\Entity\UsedScene;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsedScene|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsedScene|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsedScene[]    findAll()
 * @method UsedScene[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsedSceneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsedScene::class);
    }

    // /**
    //  * @return UsedScene[] Returns an array of UsedScene objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsedScene
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
