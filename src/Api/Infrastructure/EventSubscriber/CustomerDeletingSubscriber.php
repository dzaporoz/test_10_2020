<?php


namespace App\Api\Infrastructure\EventSubscriber;


use App\Api\Infrastructure\Persistence\UserRepository;
use App\Showroom\Infrastructure\Event\CustomerRemovedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerDeletingSubscriber implements EventSubscriberInterface
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            "showroom.customer_removed" => 'removeUser',
        ];
    }

    public function removeUser(CustomerRemovedEvent $customerRemovedEvent)
    {
        $this->userRepository->remove($customerRemovedEvent->getCustomer()->getUserAccount());
    }
}