<?php

namespace App\Repository;

use App\Entity\Planet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Planet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planet[]    findAll()
 * @method Planet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Planet::class);
    }

    public function findWithPeople()
    {
        $qb = $this->createQueryBuilder('planet')
            ->select(['planet', 'people'])
            ->join('planet.people', 'people')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findPlanetWithResidentCount()
    {
        $qb = $this->createQueryBuilder('planet')
            ->select(['planet.name', 'count(people.id) as number'])
            ->leftJoin('planet.people', 'people')
            ->groupBy('planet.id')
            ->orderBy("number", 'desc')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findPlanetWith3Resident()
    {
        $qb = $this->createQueryBuilder('planet')
            ->select(['planet.name', 'count(people.id) as number'])
            ->leftJoin('planet.people', 'people')
            ->groupBy('planet.id')
            ->having('number = 3')
            ->orderBy("number", 'desc')
        ;

        return $qb->getQuery()->getResult();
    }


}
