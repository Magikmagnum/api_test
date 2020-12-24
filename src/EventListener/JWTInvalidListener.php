<?php

namespace App\EventListener;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;


class JWTInvalidListener extends AbstractController
{

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $response = new JWTAuthenticationFailureResponse($this->statusCode(Response::HTTP_UNAUTHORIZED, [], "Votre token n'est pas valide, veuillez vous reconnecter pour en obtenir un nouveau"));

        $event->setResponse($response);
    }
}
