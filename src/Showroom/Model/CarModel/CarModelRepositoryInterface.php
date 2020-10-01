<?php


namespace App\Showroom\Model\CarModel;

interface CarModelRepositoryInterface
{
    /**
     * Finds an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return CarModel|null The object.
     */
    public function find($id);

    /**
     * Finds all objects in the repository.
     *
     * @return array<int, CarModel> The objects.
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
     * @return CarModel[] The objects.
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * Finds a single object by a set of criteria.
     *
     * @param mixed[] $criteria The criteria.
     *
     * @return CarModel|null The object.
     */
    public function findOneBy(array $criteria);

    /**
     * Gets all car brands
     *
     * @return array[]
     */
    public function getBrands();

    /**
     * Gets all car models for given brand
     *
     * @param string $brand
     *
     * @return array[]
     */
    public function getBrandModels(string $brand);
}