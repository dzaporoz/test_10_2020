<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class UnfinishedTradeInDealFoundException extends AppException
{
    protected int $status_code = 403;

    protected $message = 'This operation is unavailable since the Customer has unfinished trade in deal';
}