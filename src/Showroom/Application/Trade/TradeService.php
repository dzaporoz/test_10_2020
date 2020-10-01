<?php


namespace App\Showroom\Application\Trade;


use App\Showroom\Application\Exception\CarModelIsNotAvailableForTradeInException;
use App\Showroom\Application\Exception\CarModelNotFoundException;
use App\Showroom\Application\Exception\ClientNotFoundException;
use App\Showroom\Application\Exception\TradeInDealNotFoundException;
use App\Showroom\Application\Exception\UnfinishedTradeInDealFoundException;
use App\Showroom\Application\Exception\UnfinishedTradeInDealNotFoundException;
use App\Showroom\Application\Exception\WrongSurchargeAmountException;
use App\Showroom\Model\CarModel\CarModelRepositoryInterface;
use App\Showroom\Model\Client\Client;
use App\Showroom\Model\Client\ClientRepositoryInterface;
use App\Showroom\Model\TradeInDeal\TradeInDeal;
use App\Showroom\Model\TradeInDeal\TradeInDealRepositoryInterface;

class TradeService
{
    protected TradeInDealRepositoryInterface $tradeInDealRepository;

    protected CarModelRepositoryInterface $carModelRepository;

    protected ClientRepositoryInterface $clientRepository;

    public function __construct(
        TradeInDealRepositoryInterface $tradeInDealRepository,
        CarModelRepositoryInterface $carModelRepository,
        ClientRepositoryInterface $clientRepository
    )
    {
        $this->tradeInDealRepository = $tradeInDealRepository;
        $this->carModelRepository = $carModelRepository;
        $this->clientRepository = $clientRepository;
    }

    public function getCarBrands()
    {
        return $this->carModelRepository->getBrands();
    }

    public function getBrandModels(string $brand)
    {
        return $this->carModelRepository->getBrandModels($brand);
    }

    public function sellCarToShowroom(int $carModelId, int $clientId) : TradeInDeal
    {
        $carModel = $this->carModelRepository->find($carModelId);
        $client = $this->clientRepository->find($clientId);

        if (! $client) {
            throw new ClientNotFoundException();
        } else if (! $carModel) {
            throw new CarModelNotFoundException();
        } else if (! $carModel->getPrice()->getTradeInPrice()) {
            throw new CarModelIsNotAvailableForTradeInException();
        }

        /** @var TradeInDeal $lastTradeInDeal */
        $lastTradeInDeal = $client->getTradeInDeals()->last();
        if ($lastTradeInDeal && ! $lastTradeInDeal->getShowroomCarModel()) {
            throw new UnfinishedTradeInDealFoundException();
        }

        $tradeInDeal = new TradeInDeal();
        $tradeInDeal->setClient($client);
        $tradeInDeal->setClientCarModel($carModel);
        $tradeInDeal->setClientCarPrice($carModel->getPrice()->getTradeInPrice());

        $this->tradeInDealRepository->store($tradeInDeal);
        
        return $tradeInDeal;
    }

    public function buyCarWithASurcharge(float $surcharge_amount, int $desirableCarModelId, int $clientId) : TradeInDeal
    {
        $client = $this->clientRepository->find($clientId);
        $desirableCarModel = $this->carModelRepository->find($desirableCarModelId);

        if (! $client) {
            throw new ClientNotFoundException();
        } else if (! $desirableCarModel) {
            throw new CarModelNotFoundException();
        }

        $tradeInDeal = $this->getClientUnfinishedTradeInDeal($client);

        $givedCarModel = $tradeInDeal->getClientCarModel();
        $requiredSurchargeAmount = $desirableCarModel->getPrice()->getPrice() -
            $givedCarModel->getPrice()->getTradeInPrice();

        if ($requiredSurchargeAmount != $surcharge_amount) {
            throw new WrongSurchargeAmountException();
        } else if (! preg_match('~^[\d]+(.[\d])?([\d])?$~', $surcharge_amount)) {
            throw new WrongSurchargeFormatException();
        }

        $tradeInDeal->setShowroomCarModel($desirableCarModel);
        $tradeInDeal->setShowroomCarPrice($desirableCarModel->getPrice()->getPrice());
        $this->tradeInDealRepository->store($tradeInDeal);

        return $tradeInDeal;
    }

    protected function getClientUnfinishedTradeInDeal(Client $client)
    {
        $tradeInDeal = $client->getTradeInDeals()->last();
        if (! $tradeInDeal) {
            throw new TradeInDealNotFoundException();
        } else if ($tradeInDeal->getShowroomCarModel()) {
            throw new UnfinishedTradeInDealNotFoundException();
        }

        return $tradeInDeal;
    }
}