<?php

namespace App\Showroom\Infrastructure\Persistence;

use App\Showroom\Model\Customer\Customer;
use App\Showroom\Model\Customer\CustomerRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    protected string $entityClass = Customer::class;

    /**
     * @see CustomerRepositoryInterface
     */
    public function remove(Customer $customer)
    {
        $this->getEntityManager()->remove($customer);
        $this->getEntityManager()->flush();
    }

    /**
     * @see CustomerRepositoryInterface
     */
    public function store(Customer $customer)
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
    }
}
