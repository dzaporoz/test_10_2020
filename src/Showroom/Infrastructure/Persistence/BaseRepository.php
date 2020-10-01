<?php


namespace App\Showroom\Infrastructure\Persistence;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method object|null find($id, $lockMode = null, $lockVersion = null)
 * @method object|null findOneBy(array $criteria, array $orderBy = null)
 * @method object[]    findAll()
 * @method object[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseRepository extends ServiceEntityRepository
{
    protected string $entityClass;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->entityClass);
    }
}