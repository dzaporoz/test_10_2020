<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class CarModelIsNotAvailableForTradeInException extends AppException
{
    protected int $status_code = 403;

    protected $message = 'This car is not available for trade in';
}