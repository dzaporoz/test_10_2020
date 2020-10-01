<?php


namespace App\Showroom\Infrastructure\EventSubscriber;


use App\Api\Infrastructure\Event\CustomerUserAccountCreatedEvent;
use App\Showroom\Application\ClientManagement\ClientManagementService;
use App\Showroom\Infrastructure\Persistence\ClientRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerUserAccountCreationSubscriber implements EventSubscriberInterface
{
    protected ClientManagementService $clientManagementService;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientManagementService = new ClientManagementService($clientRepository);
    }
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            "user.customer_account_created" => 'createClient',
        ];
    }

    public function createClient(CustomerUserAccountCreatedEvent $userAccountCreatedEvent)
    {
        $this->clientManagementService->addClient($userAccountCreatedEvent->getUser());
    }
}