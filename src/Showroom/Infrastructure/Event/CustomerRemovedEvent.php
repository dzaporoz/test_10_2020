<?php


namespace App\Showroom\Infrastructure\Event;


use App\Showroom\Model\Client\Client;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerRemovedEvent extends Event
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient() : Client
    {
        return $this->client;
    }

}