<?php


namespace App\Api\Infrastructure\Event;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerUserAccountCreatedEvent extends Event
{
    private UserInterface $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser() : UserInterface
    {
        return $this->user;
    }

}