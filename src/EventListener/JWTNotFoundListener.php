<?php

namespace App\EventListener;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;


class JWTNotFoundListener extends AbstractController
{
    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $response = new JsonResponse($this->statusCode(Response::HTTP_UNAUTHORIZED, [], "Vous n'avez pas de token, veuillez vous connecter pour en obtenir un"), 401);
        $event->setResponse($response);
    }
}
