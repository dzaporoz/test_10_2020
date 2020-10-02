<?php


namespace App\Showroom\Infrastructure\Controller;

use App\Resources\Api\ApiController;
use App\Showroom\Application\Trade\TradeService;
use App\Showroom\Infrastructure\Persistence\CarModelRepository;
use App\Showroom\Infrastructure\Persistence\CustomerRepository;
use App\Showroom\Infrastructure\Persistence\TradeInDealRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class TradeController extends ApiController
{
    protected TradeService $tradeService;

    private Security $security;

    private CustomerRepository $customerRepository;

    public function __construct(
        CarModelRepository $carModelRepository,
        CustomerRepository $customerRepository,
        TradeInDealRepository $tradeInDealRepository,
        Security $security
    )
    {
        $this->tradeService = new TradeService(
            $tradeInDealRepository, $carModelRepository, $customerRepository
        );

        $this->security = $security;

        $this->customerRepository = $customerRepository;
    }

    public function getCarBrands()
    {
        $brands = $this->tradeService->getCarBrands();

        return $this->response(['brands' => $brands]);
    }

    public function getBrandModels(string $brand)
    {
        $models = $this->tradeService->getBrandModels($brand);

        return $this->response([$brand => $models]);
    }

    public function tradeInCustomerCar(Request $request)
    {
        $request = $this->transformJsonBody($request);
        $carModelId = $request->get('carModelId');

        if (! $carModelId) {
            $this->setStatusCode(400);
            return $this->response(
                [],
                'Invalid body format. Should have "carModelId" parameter'
            );
        }

        $customer = $this->customerRepository->findOneBy(['userAccount' => $this->security->getUser()]);

        $tradeInDeal = $this->tradeService->sellCarToShowroom($carModelId, $customer->getId());

        return $this->response(['tradeInDeal' => $tradeInDeal]);
    }

    public function sellCarForTradeIn(Request $request)
    {
        $request = $this->transformJsonBody($request);
        $surchargeAmount = $request->get('surchargeAmount');
        $carModelId = $request->get('carModelId');

        if (! $carModelId || ! $surchargeAmount) {
            $this->setStatusCode(400);
            return $this->response(
                [],
                'Invalid body format. Should have "surcharge_amount" AND "carModelId" parameters'
            );
        }

        $customer = $this->customerRepository->findOneBy(['userAccount' => $this->security->getUser()]);

        $tradeInDeal = $this->tradeService->buyCarWithASurcharge($surchargeAmount, $carModelId, $customer->getId());

        return $this->response(['tradeInDeal' => $tradeInDeal]);
    }
}