<?php


namespace App\Showroom\Infrastructure\Controller;


use App\Resources\Api\ApiController;
use App\Showroom\Application\ClientManagement\ClientManagementService;
use App\Showroom\Infrastructure\Event\CustomerRemovedEvent;
use App\Showroom\Model\Client\ClientRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ClientManagementController extends ApiController
{
    protected ClientRepositoryInterface $clientRepository;

    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(ClientRepositoryInterface $clientRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->clientRepository = $clientRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function list()
    {
        return $this->response(['clients' => $this->clientRepository->findAll()]);
    }

    public function delete(int $client_id)
    {
        $clientManagementService = new ClientManagementService($this->clientRepository);
        $client = $this->clientRepository->find($client_id);
        $clientManagementService->removeClient($client_id);

        $event = new CustomerRemovedEvent($client);
        $this->eventDispatcher->dispatch($event, 'showroom.customer_removed');

        $this->setStatusCode(204);
        return $this->response([]);
    }
}