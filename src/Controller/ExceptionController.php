<?php

namespace App\Controller;


use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionController extends AbstractController
{
    public function catchException(\Throwable $exception)
    {

        if ($exception instanceof NotFoundHttpException) {

            $response = $this->statusCode(Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof UniqueConstraintViolationException || $exception instanceof \TypeError) {

            $response = $this->statusCode(Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof AccessDeniedException || $exception instanceof AccessDeniedHttpException) {

            $response = $this->statusCode(Response::HTTP_FORBIDDEN);
        } else {
            $response = [
                "errors" => true,
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "message" => $exception->getMessage()
            ];
        }

        return $this->json($response, $response["status"]);
    }
}
