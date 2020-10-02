<?php


namespace App\Showroom\Infrastructure\Controller;


use App\Resources\Api\ApiController;
use App\Showroom\Application\CustomerManagement\CustomerManagementService;
use App\Showroom\Infrastructure\Event\CustomerRemovedEvent;
use App\Showroom\Model\Customer\CustomerRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CustomerManagementController extends ApiController
{
    protected CustomerRepositoryInterface $customerRepository;

    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(CustomerRepositoryInterface $customerRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->customerRepository = $customerRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function list()
    {
        return $this->response(['customers' => $this->customerRepository->findAll()]);
    }

    public function delete(int $customer_id)
    {
        $customerManagementService = new CustomerManagementService($this->customerRepository);
        $customer = $this->customerRepository->find($customer_id);
        $customerManagementService->removeCustomer($customer_id);

        $event = new CustomerRemovedEvent($customer);
        $this->eventDispatcher->dispatch($event, 'showroom.customer_removed');

        $this->setStatusCode(204);
        return $this->response([]);
    }
}