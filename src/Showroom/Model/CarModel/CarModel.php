<?php

namespace App\Showroom\Model\CarModel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarModelRepository::class)
 */
class CarModel implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $model_name;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $manufacturer_name;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $class;

    /**
     * @ORM\OneToOne(targetEntity=CarPrice::class, mappedBy="carModel", cascade={"persist", "remove"})
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelName(): ?string
    {
        return $this->model_name;
    }

    public function setModelName(string $model_name): self
    {
        $this->model_name = $model_name;

        return $this;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturer_name;
    }

    public function setManufacturerName(string $manufacturer_name): self
    {
        $this->manufacturer_name = $manufacturer_name;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getPrice(): ?CarPrice
    {
        return $this->price;
    }

    public function setPrice(CarPrice $price): self
    {
        $this->price = $price;

        // set the owning side of the relation if necessary
        if ($price->getCarModel() !== $this) {
            $price->setCarModel($this);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'manufacturer_name' => $this->getManufacturerName(),
            'model_name' => $this->getModelName(),
            'class' => $this->getClass(),
            'price' => $this->getPrice()->getPrice(),
            'trade_in_price' => $this->getPrice()->getTradeInPrice()
        ];
    }
}
