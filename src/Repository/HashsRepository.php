<?php

namespace App\Repository;

use App\Entity\Hashs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hashs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hashs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hashs[]    findAll()
 * @method Hashs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hashs::class);
    }


    public function findOneBySomeField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.hashIdentifier = :val')
            ->setParameter('val', $value)
            ->getQuery()
        ;
    }
}
