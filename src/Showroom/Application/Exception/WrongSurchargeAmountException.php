<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class WrongSurchargeAmountException extends AppException
{
    protected int $status_code = 403;

    protected $message = 'The surcharge amount doesn\'t match expected value';
}