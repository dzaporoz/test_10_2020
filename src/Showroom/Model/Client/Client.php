<?php

namespace App\Showroom\Model\Client;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Showroom\Model\TradeInDeal\TradeInDeal;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=UserInterface::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAccount;

    /**
     * @ORM\OneToMany(targetEntity=TradeInDeal::class, mappedBy="client2", orphanRemoval=true)
     */
    private $tradeInDeals;

    public function __construct()
    {
        $this->tradeInDeals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserAccount(): ?UserInterface
    {
        return $this->userAccount;
    }

    public function setUserAccount(UserInterface $userAccount): self
    {
        $this->userAccount = $userAccount;

        return $this;
    }

    /**
     * @return Collection|\App\Showroom\Model\TradeInDeal\TradeInDeal[]
     */
    public function getTradeInDeals(): Collection
    {
        return $this->tradeInDeals;
    }

    public function addTradeInDeal(TradeInDeal $tradeInDeal): self
    {
        if (!$this->tradeInDeals->contains($tradeInDeal)) {
            $this->tradeInDeals[] = $tradeInDeal;
            $tradeInDeal->setClient($this);
        }

        return $this;
    }

    public function removeTradeInDeal(TradeInDeal $tradeInDeal): self
    {
        if ($this->tradeInDeals->contains($tradeInDeal)) {
            $this->tradeInDeals->removeElement($tradeInDeal);
            // set the owning side to null (unless already changed)
            if ($tradeInDeal->getClient() === $this) {
                $tradeInDeal->setClient(null);
            }
        }

        return $this;
    }
}
