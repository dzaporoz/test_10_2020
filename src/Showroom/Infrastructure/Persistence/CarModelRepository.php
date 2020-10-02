<?php

namespace App\Showroom\Infrastructure\Persistence;

use App\Showroom\Model\CarModel\CarModel;
use App\Showroom\Model\CarModel\CarModelRepositoryInterface;

/**
 * @method CarModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarModel[]    findAll()
 * @method CarModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarModelRepository extends BaseRepository implements CarModelRepositoryInterface
{
    protected string $entityClass = CarModel::class;

    /**
     * @see CarModelRepositoryInterface
     */
    public function getBrands()
    {
        $brands_raw =  $this->createQueryBuilder('q')
            ->select('q.manufacturer_name')
            ->groupBy('q.manufacturer_name')
            ->getQuery()
            ->getResult();

        return array_column($brands_raw, 'manufacturer_name');
    }

    /**
     * @see CarModelRepositoryInterface
     */
    public function getBrandModels(string $brand)
    {
        return $this->createQueryBuilder('q')
            ->where('LOWER(q.manufacturer_name) = :val')
            ->setParameter('val', strtolower($brand))
            ->getQuery()
            ->getResult();
    }
}
