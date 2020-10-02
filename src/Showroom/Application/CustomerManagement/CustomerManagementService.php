<?php


namespace App\Showroom\Application\CustomerManagement;


use App\Showroom\Application\Exception\CustomerNotFoundException;
use App\Showroom\Application\Exception\UnfinishedTradeInDealFoundException;
use App\Showroom\Model\Customer\Customer;
use App\Showroom\Model\Customer\CustomerRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerManagementService
{
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function addCustomer(UserInterface $user)
    {
        $customer = new Customer();
        $customer->setUserAccount($user);

        $this->customerRepository->store($customer);
    }

    public function removeCustomer(int $customerId)
    {
        $customer = $this->customerRepository->find($customerId);

        if (! $customer) {
            throw new CustomerNotFoundException();
        }

        // Check for unfinished trade in deals
        $customerLastTradeInDeal = $customer->getTradeInDeals()->last();

        if ($customerLastTradeInDeal && ! $customerLastTradeInDeal->getShowroomCarModel()) {
            throw new UnfinishedTradeInDealFoundException();
        }
        
        $this->customerRepository->remove($customer);
    }
}