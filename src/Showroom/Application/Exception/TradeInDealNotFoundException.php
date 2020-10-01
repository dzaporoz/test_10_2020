<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class TradeInDealNotFoundException extends AppException
{
    protected int $status_code = 404;

    protected $message = 'Unable to find Trade in deal by given Id';
}