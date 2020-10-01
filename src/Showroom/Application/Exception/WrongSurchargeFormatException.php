<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class WrongSurchargeFormatException extends AppException
{
    protected int $status_code = 400;

    protected $message = 'The surchargeAmount parameter should be decimal';
}