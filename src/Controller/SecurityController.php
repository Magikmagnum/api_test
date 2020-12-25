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
 *      response="200",
 *      description="Authentification",
 *      @OA\JsonContent(
 *          allOf={@OA\Schema(ref="#/components/schemas/Success")},
 *          @OA\Property(type="objet", property="data", ref="#/components/schemas/Login"),
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
     *      response="201",
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

        //verification des erreurs email
        isset($data->email) ? null : $errors[] = ['path' => "email", 'message' => "Champs obligatoir"];

        //verification des erreur sur le nouveau mot de passe
        $errorPassword = "Champs obligatoir";
        if (!isset($data->password) || $errorPassword = $this->check->validatePassword($data->password)) {
            $errors[] = ['path' => "password", 'message' => $errorPassword];
        }


        if (empty($errors)) {

            $user = new User();
            $user->setEmail($data->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($data->password);

            if (!$errors = $this->check->validateOrm($validator->validate($user), $errors)) {
                $user->setPassword($encoder->encodePassword($user, $data->password));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $response = $this->statusCode(Response::HTTP_CREATED, $user);
                return $this->json($response, $response["status"], [], ["groups" => "security:new"]);
            }
        }
        $response = $this->statusCode(Response::HTTP_BAD_REQUEST, $errors);
        return $this->json($response, $response["status"]);
    }
}
