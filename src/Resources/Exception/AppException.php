<?php


namespace App\Resources\Exception;


use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AppException extends \Exception implements HttpExceptionInterface
{
    /** @var int HTTP response status code */
    protected int $status_code;

    public function setStatusCode(int $status_code)
    {
        $this->status_code = $status_code;
    }

    public function getStatusCode() : int
    {
        return $this->status_code;
    }

    public function getHeaders() : array
    {
        return [];
    }
}