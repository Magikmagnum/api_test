<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * 
 * @OA\RequestBody(
 *      request="Produit",
 *      required={"nom"},
 *      @OA\JsonContent(   
 *          @OA\Property(type="integer", property="quantite"),
 *          @OA\Property(type="string", property="nom", example="Tomate"),
 *      )
 *  )
 * 
 * @OA\Schema(
 *  schema="ProduitList",
 *  @OA\Property(type="integer", property="id"),
 *  @OA\Property(type="string", property="nom", example="Tomate"),
 * )
 * 
 * @OA\Schema(
 *  schema="Produit",
 *  @OA\Property(type="integer", property="quantite", example=30),
 *  @OA\Property(type="string", property="user"),
 *  allOf={
 *      @OA\Schema(ref="#/components/schemas/ProduitList")
 *  },
 * )
 */
class ProduitNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // Here: add, edit, or delete some data

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof \App\Entity\Produit;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
