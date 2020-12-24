<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use App\Controller\Helpers\CheckHelper;
use App\Controller\Helpers\ListenerHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * 
 * 
 * @OA\Parameter(
 *      name="id",
 *      in="path",
 *      description="ID de la resource",
 *      required=true,
 *      @OA\Schema(type="integer"),
 * )
 * 
 * @OA\Schema(
 *      schema="Created",
 *      description="Created",
 *      @OA\Property(property="status", type="integer", example=201),
 *      @OA\Property(type="boolean", property="success", example=true),
 *      @OA\Property(property="message", type="string", example="Ressource créer avec succès"),
 *     
 * )
 * 
 * 
 * @OA\Schema(
 *      schema="Success",
 *      description="Success",
 *      @OA\Property(property="status", type="integer", example=200),
 *      @OA\Property(type="boolean", property="success", example=true),
 *      @OA\Property(property="message", type="string", example="Requète effectué avec succès"),
 *     
 * )
 * 
 * 
 * @OA\Response(
 *  response="NotFound",
 *  @OA\JsonContent(
 *      @OA\Property(property="status", type="integer", example=404),
 *      @OA\Property(type="boolean", property="success", example=false),
 *      @OA\Property(property="message", type="string", example="Ressource inexistante"),
 *  )
 * ),
 * 
 * 
 * 
 * @OA\Response(
 *  response="Unauthorized",
 *  @OA\JsonContent(
 *      @OA\Property(property="status", type="integer", example=401),
 *      @OA\Property(type="boolean", property="success", example=false),
 *      @OA\Property(property="message", type="string", example="Impossible de vous authentifier"),
 *  )
 * ),
 * 
 * 
 * 
 * @OA\Response(
 *  response="BadRequest",
 *  @OA\JsonContent(
 *      @OA\Property(property="status", type="integer", example=400),
 *      @OA\Property(type="boolean", property="success", example=false),
 *      @OA\Property(property="message", type="string", example="Requète invalide"),
 *  )
 * ),
 * 
 * 
 * 
 * @OA\Response(
 *  response="ForBidden",
 *  @OA\JsonContent(
 *      @OA\Property(property="status", type="integer", example=403),
 *      @OA\Property(type="boolean", property="success", example=false),
 *      @OA\Property(property="message", type="string", example="Vous n'avez pas les droits requis"),
 *  )
 * ),
 * 
 * 
 * 
 * @OA\SecurityScheme(bearerFormat="JWT", type="apiKey", securityScheme="bearer"),
 */
class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    protected $check;
    protected $listener;


    public function __construct()
    {
        $this->check = new CheckHelper();
    }



    public function getChecker()
    {
        return $this->check;
    }

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


    public function statusCode($statusCode, $data = [], string $message = null)
    {
        switch ($statusCode) {

            case Response::HTTP_CREATED:

                $message === null && $message = "Ressource créer avec succès";
                return $this->response(true, $statusCode, $data, $message);
                break;

            case Response::HTTP_OK:

                $message === null && $message = "Operation reussie";
                return $this->response(true, $statusCode, $data, $message);
                break;

            case Response::HTTP_BAD_REQUEST:

                $message === null && $message = "Requète invalide";
                return $this->response(false, $statusCode, $data, $message);
                break;

            case Response::HTTP_UNAUTHORIZED:

                $message === null && $message = "Impossible de vous authentifier, veuillez vous connecter";
                return $this->response(false, $statusCode, $data, $message);
                break;

            case Response::HTTP_FORBIDDEN:

                $message === null && $message = "Vous n'avez pas les droits requis pour continuer cette action";
                return $this->response(false, $statusCode, $data, $message);
                break;

            case Response::HTTP_NOT_FOUND:

                $message === null && $message = "Route ou ressource inexistante, vérifier le lien de la requète";
                return $this->response(false, $statusCode, $data, $message);
                break;

            case Response::HTTP_NOT_MODIFIED:

                $message === null && $message = "Ressource non modifier";
                return $this->response(false, $statusCode, $data, $message);
                break;


            case Response::HTTP_UNSUPPORTED_MEDIA_TYPE:

                $message === null && $message = "Ressource pas supporté";
                return $this->response(false, $statusCode, $data, $message);
                break;
        }
    }

    private function response($success, $statusCode, $data = [], $message = null)
    {
        $response = ["status" => $statusCode, "success" => $success];
        $data ? $response["data"] = $data : null;
        $message ? $response["message"] = $message : null;
        return $response;
    }
}
