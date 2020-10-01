<?php


namespace App\Showroom\Application\Exception;


use App\Resources\Exception\AppException;

class CarModelNotFoundException extends AppException
{
    protected int $status_code = 404;

    protected $message = 'Unable to find car model by given Id';
}