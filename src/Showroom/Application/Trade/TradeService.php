<?php


namespace App\Showroom\Application\Trade;


use App\Showroom\Application\Exception\CarModelIsNotAvailableForTradeInException;
use App\Showroom\Application\Exception\CarModelNotFoundException;
use App\Showroom\Application\Exception\CustomerNotFoundException;
use App\Showroom\Application\Exception\TradeInDealNotFoundException;
use App\Showroom\Application\Exception\UnfinishedTradeInDealFoundException;
use App\Showroom\Application\Exception\UnfinishedTradeInDealNotFoundException;
use App\Showroom\Application\Exception\WrongSurchargeAmountException;
use App\Showroom\Application\Exception\WrongSurchargeFormatException;
use App\Showroom\Model\CarModel\CarModelRepositoryInterface;
use App\Showroom\Model\Customer\Customer;
use App\Showroom\Model\Customer\CustomerRepositoryInterface;
use App\Showroom\Model\TradeInDeal\TradeInDeal;
use App\Showroom\Model\TradeInDeal\TradeInDealRepositoryInterface;

class TradeService
{
    protected TradeInDealRepositoryInterface $tradeInDealRepository;

    protected CarModelRepositoryInterface $carModelRepository;

    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(
        TradeInDealRepositoryInterface $tradeInDealRepository,
        CarModelRepositoryInterface $carModelRepository,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->tradeInDealRepository = $tradeInDealRepository;
        $this->carModelRepository = $carModelRepository;
        $this->customerRepository = $customerRepository;
    }

    public function getCarBrands()
    {
        return $this->carModelRepository->getBrands();
    }

    public function getBrandModels(string $brand)
    {
        return $this->carModelRepository->getBrandModels($brand);
    }

    public function sellCarToShowroom(int $carModelId, int $customerId) : TradeInDeal
    {
        $carModel = $this->carModelRepository->find($carModelId);
        $customer = $this->customerRepository->find($customerId);

        if (! $customer) {
            throw new CustomerNotFoundException();
        } else if (! $carModel) {
            throw new CarModelNotFoundException();
        } else if (! $carModel->getPrice()->getTradeInPrice()) {
            throw new CarModelIsNotAvailableForTradeInException();
        }

        /** @var TradeInDeal $lastTradeInDeal */
        $lastTradeInDeal = $customer->getTradeInDeals()->last();
        if ($lastTradeInDeal && ! $lastTradeInDeal->getShowroomCarModel()) {
            throw new UnfinishedTradeInDealFoundException();
        }

        $tradeInDeal = new TradeInDeal();
        $tradeInDeal->setCustomer($customer);
        $tradeInDeal->setCustomerCarModel($carModel);

        $this->tradeInDealRepository->store($tradeInDeal);
        
        return $tradeInDeal;
    }

    public function buyCarWithASurcharge(float $surcharge_amount, int $desirableCarModelId, int $customerId) : TradeInDeal
    {
        $customer = $this->customerRepository->find($customerId);
        $desirableCarModel = $this->carModelRepository->find($desirableCarModelId);

        if (! $customer) {
            throw new CustomerNotFoundException();
        } else if (! $desirableCarModel) {
            throw new CarModelNotFoundException();
        }

        $tradeInDeal = $this->getCustomerUnfinishedTradeInDeal($customer);

        $givedCarModel = $tradeInDeal->getCustomerCarModel();
        $requiredSurchargeAmount = $desirableCarModel->getPrice()->getPrice() -
            $givedCarModel->getPrice()->getTradeInPrice();

        if ($requiredSurchargeAmount != $surcharge_amount) {
            throw new WrongSurchargeAmountException();
        } else if (! preg_match('~^[\d]+(.[\d])?([\d])?$~', $surcharge_amount)) {
            throw new WrongSurchargeFormatException();
        }

        $tradeInDeal->setShowroomCarModel($desirableCarModel);
        $this->tradeInDealRepository->store($tradeInDeal);

        return $tradeInDeal;
    }

    protected function getCustomerUnfinishedTradeInDeal(Customer $customer)
    {
        $tradeInDeal = $customer->getTradeInDeals()->last();
        if (! $tradeInDeal) {
            throw new TradeInDealNotFoundException();
        } else if ($tradeInDeal->getShowroomCarModel()) {
            throw new UnfinishedTradeInDealNotFoundException();
        }

        return $tradeInDeal;
    }
}