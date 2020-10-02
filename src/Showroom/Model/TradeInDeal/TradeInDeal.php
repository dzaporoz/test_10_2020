<?php

namespace App\Showroom\Model\TradeInDeal;

use App\Repository\TradeInDealRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Showroom\Model\CarModel\CarModel;
use App\Showroom\Model\Customer\Customer;

/**
 * @ORM\Entity(repositoryClass=App\Showroom\Infrastructure\Persistence\TradeInDealRepository::class)
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
    private $customerCarModel;

    /**
     * @ORM\ManyToOne(targetEntity=CarModel::class)
     */
    private $showroomCarModel;

    /**
     * @ORM\Column(type="decimal")
     */
    private $customerCarPrice;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $showroomCarPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="tradeInDeals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerCarModel(): ?CarModel
    {
        return $this->customerCarModel;
    }

    public function setCustomerCarModel(?CarModel $customerCarModel): self
    {
        $this->customerCarModel = $customerCarModel;

        $this->setCustomerCarPrice($customerCarModel->getPrice()->getTradeInPrice());

        return $this;
    }

    public function getShowroomCarModel(): ?CarModel
    {
        return $this->showroomCarModel;
    }

    public function setShowroomCarModel(?CarModel $showroomCarModel): self
    {
        $this->showroomCarModel = $showroomCarModel;

        $this->setShowroomCarPrice($showroomCarModel->getPrice()->getPrice());

        return $this;
    }

    public function getCustomerCarPrice(): float
    {
        return $this->customerCarPrice;
    }

    public function setCustomerCarPrice(float $customerCarPrice): self
    {
        $this->customerCarPrice = $customerCarPrice;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'trade_in_car_model' => $this->getCustomerCarModel(),
            'trade_in_car_price' => $this->getCustomerCarPrice(),
            'bought_car_model' => $this->getShowroomCarModel(),
            'bought_car_price' => $this->getShowroomCarPrice(),
        ];
    }
}
