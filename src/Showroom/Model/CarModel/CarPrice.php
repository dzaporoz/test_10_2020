<?php

namespace App\Showroom\Model\CarModel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CarPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2, nullable=true)
     */
    private $tradeInPrice;

    /**
     * @ORM\OneToOne(targetEntity=CarModel::class, inversedBy="price", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $carModel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTradeInPrice(): ?string
    {
        return $this->tradeInPrice;
    }

    public function setTradeInPrice(?string $tradeInPrice): self
    {
        $this->tradeInPrice = $tradeInPrice;

        return $this;
    }

    public function getCarModel(): ?CarModel
    {
        return $this->carModel;
    }

    public function setCarModel(CarModel $carModel): self
    {
        $this->carModel = $carModel;

        return $this;
    }
}
