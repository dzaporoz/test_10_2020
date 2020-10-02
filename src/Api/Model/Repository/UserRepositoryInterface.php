<?php

namespace App\Api\Model\Repository;

use App\Api\Model\Entity\User;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface UserRepositoryInterface
{

    /**
     * Removes User from DB
     *
     * @param UserInterface $user
     */
    public function remove(UserInterface $user);
}
