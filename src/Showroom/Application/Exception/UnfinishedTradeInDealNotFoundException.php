<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class UnfinishedTradeInDealNotFoundException extends AppException
{
    protected int $status_code = 409;

    protected $message = 'This operation is unavailable since the Customer doesn\'t have active trade in deal';
}