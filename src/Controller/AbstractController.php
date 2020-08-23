<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 *  @OA\Post(
 *  path="/login_check",
 *  tags={"Securities"},
 *  @OA\RequestBody(
 *      request="Login",
 *      description="Corp de la requete",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Property(type="string", property="username", example="coucou@exemple.com"),
 *          @OA\Property(type="string", property="passeword", required=true, example="emileA15ans"),
 *      )
 *  ), 
 * 
 *  @OA\Response(
 *      response="201",
 *      description="Authentification",
 *      @OA\JsonContent(
 *          @OA\Property(type="string", property="token", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1OTgxNjAyNzMsImV4cCI6MTYwMTc2MDI3Mywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiZXJpY2dhbnNhQGdtYWlsLmNvbSJ9.p14Rf3DamoYkm6JocTMH9kpPL0Qb_WqEeNyxxFLi9NuvDS4hu1qTiFXrDDpDqAMpQnL8D3Xvy4yJnb1j6ji9vnQmoEHfVBzJ3BdS34O07nMdRmriOvN3LTVInSOrLlgbd4NGryfWvfxjd1LGJ86Q9-d87gqg7dop_zWqMLaTAwApRwbR9GLOQ6lv7EW74AmKR_O3xfnUzM2tdlaYZ9Wl02yQtD4qwV0raI9KiPfoDtFamgMPAQ7pc4D_Tz2i3-n0slSGM_S2VwpCZFCGuMAMl4dxOujpk-KLqqdsaU-0YT7aqeZOGKBKo9YII2DrM9TAFYEaSSX5SNhs57NWHyacH8YvzDkuVRwJG6Nq-gck2gPcB6uTogn14dIfZnoGT87fd5vWCfyB9OgLLd17bqqcACSBQoTacXElBvGEtb4VBbtjazDHtkP2Om4AghlwYZkrfDyfLjBojcTQ4zVfTGURNTnJ8zmL33VFShgoKSPi7WDddDav1f44dKkt1K_fTl1R2biVdnUtoTxYmQ3nu0Nyginjnl6tmAddqsNDh8oCapw4aoz3uF1AS8ilsX6r1A-NVW8b9l0Z1Om6AIE4J0f-ShpnUPLjjJ4HurO4hDMwqpKlbaFcj1SIkiNT8rCMYBaMN3NDAABfJfcOI-V9fowfi_fT5X7IKUHOd6ZdwsHauzk"),
 *      ),
 *  ),
 * 
 *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
 *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
 *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
 * 
 * )
 * 
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
 * @OA\Response(
 *  response="NotFound",
 *  @OA\JsonContent(
 *      @OA\Property(property="message", type="string", example="Ressource inexistante"),
 *      @OA\Property(property="status", type="integer", example=404)
 *  )
 * ),
 * 
 * 
 * 
 * @OA\Response(
 *  response="BadRequest",
 *  @OA\JsonContent(
 *      @OA\Property(property="message", type="string", example="Requète invalide"),
 *      @OA\Property(property="status", type="integer", example=400)
 *  )
 * ),
 * 
 * 
 * 
 * @OA\Response(
 *  response="ForBidden",
 *  @OA\JsonContent(
 *      @OA\Property(property="message", type="string", example="Vous n'avez pas les droits requis pour mener cette action"),
 *      @OA\Property(property="status", type="integer", example=403)
 *  )
 * ),
 * 
 * 
 * 
 * @OA\SecurityScheme(bearerFormat="JWT", type="apiKey", securityScheme="bearer"),
 */
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
