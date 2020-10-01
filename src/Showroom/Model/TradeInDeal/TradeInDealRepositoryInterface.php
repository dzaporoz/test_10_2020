<?php

namespace App\Showroom\Model\TradeInDeal;

interface TradeInDealRepositoryInterface
{
    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return TradeInDeal|null The object.
     */
    public function find($id);

    /**
     * Finds all objects in the repository.
     *
     * @return array<int, TradeInDeal> The objects.
     */
    public function findAll();

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param mixed[]       $criteria
     * @param string[]|null $orderBy
     * @param int|null      $limit
     * @param int|null      $offset
     *
     * @return TradeInDeal[] The objects.
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * Finds a single object by a set of criteria.
     *
     * @param mixed[] $criteria The criteria.
     *
     * @return TradeInDeal|null The object.
     */
    public function findOneBy(array $criteria);

    /**
     * Stores a new object to repository or applying changes to existing object
     *
     * @param TradeInDeal $tradeInDeal New object.
     *
     * @return void
     */
    public function store(TradeInDeal $tradeInDeal);
}
