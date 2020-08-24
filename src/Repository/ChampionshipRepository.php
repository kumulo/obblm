<?php

namespace App\Repository;

use App\Entity\Championship;
use App\Entity\Coach;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @method Championship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Championship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Championship[]    findAll()
 * @method Championship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChampionshipRepository extends ServiceEntityRepository
{
    protected $security;
    public function __construct(ManagerRegistry $registry, TokenStorageInterface $security)
    {
        $this->security = $security;
        parent::__construct($registry, Championship::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getCoachChampionships() {
        $user = $this->security->getToken()->getUser();
        return $this->createQueryBuilder('champ')
            ->join(Team::class, 'team')
            ->join(Coach::class, 'manager')
            ->where('team.coach = :coach')
            ->orWhere('manager = :coach')
            ->setParameter(':coach', $user);
    }

    /**
     * @return Championship[]
     */
    public function findCoachChampionships() {
        $qb = $this->getCoachChampionships();
        return $qb->getQuery()->getResult();
    }

    /**
     * @return Championship[]
     */
    public function findCoachAllowedChampionships() {
        $qb = $this->getCoachChampionships();
        // TODO : add some other criteria
        return $qb->getQuery()->getResult();
    }
}
