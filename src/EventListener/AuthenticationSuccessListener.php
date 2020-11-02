<?php

namespace App\EventListener;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;


class AuthenticationSuccessListener extends AbstractController
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $event->setData($this->statusCode(Response::HTTP_OK, $event->getData()));
    }
}
