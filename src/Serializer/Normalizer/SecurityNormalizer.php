<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use OpenApi\Annotations as OA;

/**
 * 
 * 
 * @OA\Schema(
 *      schema="Security",
 *      description="Inscription à l'API Sentinelle",
 *      allOf={@OA\Schema(ref="#/components/schemas/Created")},
 *      @OA\Property(type="object", property="data", ref="#/components/schemas/User"),
 *      @OA\Property(type="string", property="message", example=""),
 * )
 * 
 * 
 * @OA\Schema(
 *      schema="User",
 *      description="User",
 *      @OA\Property(type="integer", property="id", example=5),
 *      @OA\Property(type="string", property="email", example="coucou@exemple.com"),
 * )
 * 
 * 
 */
class SecurityNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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
        return $data instanceof \App\Entity\User;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
