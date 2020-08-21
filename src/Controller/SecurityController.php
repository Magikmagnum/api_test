<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="security_register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {

        try {
            $data = json_decode($request->getContent());

            $user = new User();
            $user->setEmail($data->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($encoder->encodePassword($user, $data->password));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $response = [
                "errors" => false,
                "status" => 201,
                "data" => $user,
            ];
        } catch (\Throwable $e) {
            $response = [
                "errors" => true,
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => $e->getMessage()
            ];
        }
        return $this->json($response, $response["status"], []);
    }
}
