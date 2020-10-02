<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class CustomerNotFoundException extends AppException
{
    protected int $status_code = 404;

    protected $message = 'Unable to find a Customer by given Id';
}