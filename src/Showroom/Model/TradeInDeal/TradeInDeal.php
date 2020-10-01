<?php

namespace App\Showroom\Model\TradeInDeal;

use App\Repository\TradeInDealRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Showroom\Model\CarModel\CarModel;
use App\Showroom\Model\Client\Client;

/**
 * @ORM\Entity(repositoryClass=TradeInDealRepository::class)
 */
class TradeInDeal implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=CarModel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientCarModel;

    /**
     * @ORM\ManyToOne(targetEntity=CarModel::class)
     */
    private $showroomCarModel;

    /**
     * @ORM\Column(type="decimal")
     */
    private $clientCarPrice;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $showroomCarPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="tradeInDeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientCarModel(): ?CarModel
    {
        return $this->clientCarModel;
    }

    public function setClientCarModel(?CarModel $clientCarModel): self
    {
        $this->clientCarModel = $clientCarModel;

        return $this;
    }

    public function getShowroomCarModel(): ?CarModel
    {
        return $this->showroomCarModel;
    }

    public function setShowroomCarModel(?CarModel $showroomCarModel): self
    {
        $this->showroomCarModel = $showroomCarModel;

        return $this;
    }

    public function getClientCarPrice(): float
    {
        return $this->clientCarPrice;
    }

    public function setClientCarPrice(float $clientCarPrice): self
    {
        $this->clientCarPrice = $clientCarPrice;

        return $this;
    }

    public function getShowroomCarPrice(): ?float
    {
        return $this->showroomCarPrice;
    }

    public function setShowroomCarPrice(float $showroomCarPrice): self
    {
        $this->showroomCarPrice = $showroomCarPrice;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'trade_in_car_model' => $this->getClientCarModel(),
            'trade_in_car_price' => $this->getClientCarPrice(),
            'bought_car_model' => $this->getShowroomCarModel(),
            'bought_car_price' => $this->getShowroomCarPrice(),
        ];
    }
}
