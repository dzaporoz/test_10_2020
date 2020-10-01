<?php


namespace App\Showroom\Application\ClientManagement;


use App\Showroom\Application\Exception\ClientNotFoundException;
use App\Showroom\Application\Exception\UnfinishedTradeInDealFoundException;
use App\Showroom\Model\Client\ClientRepositoryInterface;

class ClientManagementService
{
    protected ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function removeClient(int $clientId)
    {
        $client = $this->clientRepository->find($clientId);

        if (! $client) {
            throw new ClientNotFoundException();
        }

        // Check for unfinished trade in deals
        $clientLastTradeInDeal = $client->getTradeInDeals()->last();
        if (! $clientLastTradeInDeal->getShowroomCarModel()) {
            throw new UnfinishedTradeInDealFoundException();
        }
        
        $this->clientRepository->remove($client);
    }
}