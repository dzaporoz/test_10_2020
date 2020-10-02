<?php


namespace App\Api\Infrastructure\EventListener;

use App\Resources\Api\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTEventListener
{
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $event->setData([
            'timestamp' => time(),
            'status'    => 'success',
            'code' => $event->getResponse()->getStatusCode(),
            'data' => $event->getData(),
        ]);
    }

    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $event->setResponse(new ApiResponse(
            null,
            401,
            'Bad credentials, please verify that your username/password are correctly set'
        ));
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $event->setResponse(new ApiResponse(
            null,
            403,
            'Your token is invalid, please login again to get a new one'
        ));
    }

    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $event->setResponse(new ApiResponse(
            null,
            403,
            'Missing token'
        ));
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $event->setResponse(new ApiResponse(
            null,
            403,
            'Your token is expired, please login again to get a new one'
        ));
    }
}