<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    public function getDatime($var = 'now')
    {
        return new \DateTime($var, new \DateTimeZone('Africa/Libreville'));
    }


    public function getErrors($entity, ValidatorInterface $validator)
    {
        $errors = $validator->validate($entity);

        if (count($errors) > 0) {

            $array = [];

            foreach ($errors as $error) {
                $array[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->statusCode(Response::HTTP_BAD_REQUEST, $array);
        }

        return null;
    }


    public function statusCode($statusCode, $data = [])
    {
        switch ($statusCode) {

            case Response::HTTP_CREATED:
                return $this->response(false, $statusCode, $data, 'Ressource céée avec succès');
                break;

            case Response::HTTP_OK:
                return $this->response(true, $statusCode, $data, 'Requète effectué avec succès');
                break;

            case Response::HTTP_BAD_REQUEST:
                return $this->response(true, $statusCode, $data, 'Requète invalide');
                break;

            case Response::HTTP_UNAUTHORIZED:
                return $this->response(true, $statusCode, $data, "Connectez-vous pour mener cette action");
                break;

            case Response::HTTP_FORBIDDEN:
                return $this->response(true, $statusCode, $data, "Vous n'avez pas les droits requis pour mener cette action");
                break;

            case Response::HTTP_NOT_FOUND:
                return $this->response(true, $statusCode, $data, 'Ressource inexistante');
                break;

            case Response::HTTP_NOT_MODIFIED:
                return $this->response(true, $statusCode, $data, 'Ressource non modifier');
                break;


            case Response::HTTP_UNSUPPORTED_MEDIA_TYPE:
                return $this->response(true, $statusCode, $data, "Ressource pas supporté");
                break;
        }
    }

    private function response($error, $statusCode, $data = [], $message = null)
    {
        $response = ["status" => $statusCode, "errors" => $error];
        $data ? $response["data"] = $data : null;
        $message ? $response["message"] = $message : null;
        return $response;
    }
}
