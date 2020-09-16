<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use OpenApi\Annotations as OA;

/**
 *  
 * @OA\Post(
 *  path="/api/v1/login_check",
 *  tags={"Securities"},
 *  @OA\RequestBody(
 *      request="Login",
 *      description="Corp de la requete",
 *      required=true,
 *      @OA\JsonContent(
 *          @OA\Property(type="string", property="username", example="coucou@exemple.com"),
 *          @OA\Property(type="string", property="password", required=true, example="emileA15ans"),
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
 */
class SecurityController extends AbstractController
{

    /**
     * 
     * @Route("/register", name="security_register", methods={"POST"})
     * 
     * @OA\Post(
     *  path="/api/v1/register",
     *  tags={"Securities"},
     *  @OA\RequestBody(
     *      request="Register",
     *      description="Corp de la requete",
     *      required=true,
     *      @OA\JsonContent(
     *          @OA\Property(type="string", property="email", example="coucou@exemple.com"),
     *          @OA\Property(type="string", property="password", required=true, example="emileA15ans"),
     *      )
     *  ), 
     * 
     *  @OA\Response(
     *      response="200",
     *      description="Inscription",
     *      @OA\JsonContent(ref="#/components/schemas/Security"),
     *  ),
     * 
     *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
     *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
     *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
     * 
     * )
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent());

        $errors = [];
        isset($data->email) ? null : $errors['email'] = 'Champs Obligatoir';
        isset($data->password) ? null : $errors['password'] = 'Champs Obligatoir';

        if (empty($errors)) {

            $user = new User();
            $user->setEmail($data->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($encoder->encodePassword($user, $data->password));

            if (!$response = $this->getErrors($user, $validator)) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $response = $this->statusCode(Response::HTTP_CREATED, $user);
            }
        } else {
            $response = $this->statusCode(Response::HTTP_BAD_REQUEST);
        }

        return $this->json($response, $response["status"], [], ["groups" => "security:new"]);
    }
}
