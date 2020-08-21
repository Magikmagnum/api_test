<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="security_register", methods={"POST"})
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

        return $this->json($response, $response["status"], []);
    }
}
