<?php


namespace App\Showroom\Infrastructure\EventSubscriber;


use App\Api\Infrastructure\Event\CustomerUserAccountCreatedEvent;
use App\Showroom\Application\CustomerManagement\CustomerManagementService;
use App\Showroom\Infrastructure\Persistence\CustomerRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerUserAccountCreationSubscriber implements EventSubscriberInterface
{
    protected CustomerManagementService $customerManagementService;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerManagementService = new CustomerManagementService($customerRepository);
    }
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            "user.customer_account_created" => 'createCustomer',
        ];
    }

    public function createCustomer(CustomerUserAccountCreatedEvent $userAccountCreatedEvent)
    {
        $this->customerManagementService->addCustomer($userAccountCreatedEvent->getUser());
    }
}