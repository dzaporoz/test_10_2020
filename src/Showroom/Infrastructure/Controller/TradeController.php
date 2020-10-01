<?php


namespace App\Showroom\Infrastructure\Controller;

use App\Resources\Api\ApiController;
use App\Showroom\Application\Trade\TradeService;
use App\Showroom\Infrastructure\Persistence\CarModelRepository;
use App\Showroom\Infrastructure\Persistence\ClientRepository;
use App\Showroom\Infrastructure\Persistence\TradeInDealRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class TradeController extends ApiController
{
    protected TradeService $tradeService;

    private Security $security;

    private ClientRepository $clientRepository;

    public function __construct(
        CarModelRepository $carModelRepository,
        ClientRepository $clientRepository,
        TradeInDealRepository $tradeInDealRepository,
        Security $security
    )
    {
        $this->tradeService = new TradeService(
            $tradeInDealRepository, $carModelRepository, $clientRepository
        );

        $this->security = $security;

        $this->clientRepository = $clientRepository;
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

    public function tradeInClientCar(Request $request)
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

        $client = $this->clientRepository->findOneBy(['userAccount' => $this->security->getUser()]);

        $this->tradeService->sellCarToShowroom($carModelId, $client->getId());
    }
}