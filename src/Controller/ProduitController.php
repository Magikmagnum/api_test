<?php

namespace App\Controller;

use Throwable;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="api_produit_list", methods={"GET"})
     * 
     *
     * @OA\Get(
     * 
     *  path="/api/v1/produit",
     *  tags={"Produits"},
     *  security={"bearer"},
     * 
     *  @OA\Response(
     *      response="200",
     *      description="Liste des produits",
     *      @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ProduitList")),
     *  ),
     *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
     *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
     *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
     * 
     * )
     */
    public function index(ProduitRepository $produitRepository)
    {
        if ($data = $produitRepository->findAll()) {
            $response = $this->statusCode(Response::HTTP_OK, $data);
        } else {
            $response = $this->statusCode(Response::HTTP_NOT_FOUND);
        }
        return $this->json($response, $response["status"], [], ["groups" => "produit:list"]);
    }


    /**
     * @Route("/produit/{id}", name="api_produit_show", methods={"GET"})
     * 
     * 
     * 
     * 
     * @OA\Get(
     *  path="/api/v1/produit/{id}",
     *  tags={"Produits"},
     *  security={"bearer"},
     * 
     *  @OA\Parameter(ref="#/components/parameters/id"),
     * 
     *  @OA\Response(
     *      response="200",
     *      description="Detail du produit",
     *      @OA\JsonContent(ref="#/components/schemas/Produit"),
     *  ),
     * 
     *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
     *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
     *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
     * 
     * )
     */
    public function show($id, ProduitRepository $produitRepository)
    {
        if ($data = $produitRepository->find($id)) {
            $response = $this->statusCode(Response::HTTP_OK, $data);
        } else {
            $response = $this->statusCode(Response::HTTP_NOT_FOUND);
        }
        return $this->json($response, $response["status"], [], ["groups" => "produit:show"]);
    }



    /**
     * @Route("/produit", name="api_produit_new", methods={"POST"})
     * 
     * 
     * @OA\Post(
     *  path="/api/v1/produit",
     *  tags={"Produits"},
     *  security={"bearer"},
     * 
     *  @OA\RequestBody(ref="#/components/requestBodies/Produit"), 
     *  @OA\Response(
     *      response="201",
     *      description="Ajout d'un produit",
     *      @OA\JsonContent(ref="#/components/schemas/Produit"),
     *  ),
     * 
     *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
     *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
     *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
     * 
     * )
     */
    public function new(Request $request, ProduitRepository $produitRepository)
    {

        if ($user = $this->getUser()) {
            $response = [
                "errors" => false,
                "status" => Response::HTTP_CREATED,
            ];

            $data = json_decode($request->getContent());

            $produit = new Produit();
            $produit->setNom($data->nom)
                ->setQuantite($data->quantite)
                ->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            $response = $this->statusCode(Response::HTTP_CREATED, $produit);
        } else {
            $response = $this->statusCode(Response::HTTP_UNAUTHORIZED);
        }


        return $this->json($response, $response["status"], [], ["groups" => "produit:show"]);
    }


    /**
     * @Route("/produit/{id}", name="api_produit_edit", methods={"PUT"})
     * 
     * 
     * @Route("/api/v1/produit", name="security_api/v1/produit", methods={"POST"})
     * 
     * @OA\Put(
     *  path="/api/v1/produit/{id}",
     *  tags={"Produits"},
     *  security={"bearer"},
     * 
     *  @OA\Parameter(ref="#/components/parameters/id"),
     *  @OA\RequestBody(ref="#/components/requestBodies/Produit"),
     *  @OA\Response(
     *      response="200",
     *      description="Modification d'un produit",
     *      @OA\JsonContent(ref="#/components/schemas/Produit"),
     *  ),
     * 
     *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
     *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
     *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
     * 
     * )
     */
    public function edit($id, Request $request, ProduitRepository $produitRepository)
    {

        if ($user = $this->getUser()) {

            $produit = $produitRepository->find($id);

            if (!$produit) {
                $response = [
                    "errors" => true,
                    "status" => Response::HTTP_NOT_FOUND,
                    "message" => "Produit not found"
                ];
                return $this->json($response, $response["status"]);
            }

            $this->denyAccessUnlessGranted('EDIT', $produit);

            $data = json_decode($request->getContent());

            $produit->setNom($data->nom)
                ->setQuantite($data->quantite)
                ->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            $response = $this->statusCode(Response::HTTP_OK, $produit);
        } else {
            $response = $this->statusCode(Response::HTTP_UNAUTHORIZED);
        }

        return $this->json($response, $response["status"], [], ["groups" => "produit:show"]);
    }


    /**
     * @Route("/produit/{id}", name="api_produit_delete", methods={"DELETE"})
     * 
     *
     * @OA\Delete(
     *  path="/api/v1/produit",
     *  tags={"Produits"},
     *  security={"bearer"},
     * 
     *  @OA\Parameter(ref="#/components/parameters/id"),
     *  @OA\Response( response="200", ref="#/components/responses/Success" ),
     *  @OA\Response( response="400", ref="#/components/responses/BadRequest" ),
     *  @OA\Response( response="403", ref="#/components/responses/ForBidden" ),
     *  @OA\Response( response="404", ref="#/components/responses/NotFound" ),
     * 
     * )
     */
    public function delete($id, ProduitRepository $produitRepository)
    {
        if ($produit = $produitRepository->find($id)) {
            $this->denyAccessUnlessGranted('DELETE', $produit);
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
            $response = $this->statusCode(Response::HTTP_OK);
        } else {
            $response = $this->statusCode(Response::HTTP_NOT_FOUND);
        }

        return $this->json($response, $response["status"]);
    }
}
