<?php

namespace App\Showroom\Infrastructure\Persistence;

use App\Showroom\Model\Client\Client;
use App\Showroom\Model\Client\ClientRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    protected string $entityClass = Client::class;

    public function remove(Client $client)
    {
        $this->getEntityManager()->remove($client);
    }
}
