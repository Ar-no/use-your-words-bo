<?php

namespace App\Repository;

use App\Entity\Party;
use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Vote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vote[]    findAll()
 * @method Vote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    public function findAllVotesByParty(Party $party)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT v FROM App\Entity\Vote v JOIN v.answer a JOIN a.player pl WHERE pl.party = :party');
        $query->setParameter('party', $party);
        $votes = $query->getResult();

        return $votes;
    }
}
