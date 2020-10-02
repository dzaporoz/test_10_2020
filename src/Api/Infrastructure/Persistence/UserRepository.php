<?php

namespace App\Api\Infrastructure\Persistence;

use App\Api\Model\Entity\User;
use App\Api\Model\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @see UserRepositoryInterface
     */
    public function removeById(int $id)
    {
        $query = $this->createQueryBuilder('du')
            ->delete('du')
            ->where('du.id = :id')
            ->setParameter("id", $id)
            ->getQuery()
            ->execute();
    }

    /**
     * @see UserRepositoryInterface
     */
    public function remove(UserInterface $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
