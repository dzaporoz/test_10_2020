<?php


namespace App\Showroom\Infrastructure\Event;


use App\Showroom\Model\Customer\Customer;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerRemovedEvent extends Event
{
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer() : Customer
    {
        return $this->customer;
    }

}