<?php

namespace App\Showroom\Infrastructure\Persistence;

use App\Showroom\Model\TradeInDeal\TradeInDeal;
use App\Showroom\Model\TradeInDeal\TradeInDealRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TradeInDeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method TradeInDeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradeInDeal[]    findAll()
 * @method TradeInDeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeInDealRepository extends BaseRepository implements TradeInDealRepositoryInterface
{
    protected string $entityClass = TradeInDeal::class;

    public function store(TradeInDeal $tradeInDeal)
    {
        $this->getEntityManager()->persist($tradeInDeal);
    }
}
