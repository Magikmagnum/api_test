<?php

namespace App\EventListener;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;


class JWTExpiredListener extends AbstractController
{
    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $response = new JWTAuthenticationFailureResponse($this->statusCode(Response::HTTP_UNAUTHORIZED, [], "Votre session a expiré, veuillez le renouveler."));
        $event->setResponse($response);
    }
}
