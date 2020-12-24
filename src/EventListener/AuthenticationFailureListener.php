<?php

namespace App\EventListener;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;



class AuthenticationFailureListener extends AbstractController
{
    /**
     * @param AuthenticationFailureEvent  $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent  $event)
    {
        $response = new JWTAuthenticationFailureResponse($this->statusCode(Response::HTTP_UNAUTHORIZED, [], "Impossible de vous authentifier, mot de passe ou email invalide"));
        $event->setResponse($response);
    }
}
