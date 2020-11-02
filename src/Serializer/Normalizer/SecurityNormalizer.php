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
 *      schema="Login",
 *      description="Authentification à l'API Sentinelle",
 *      @OA\Property(type="string", property="token", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1OTgxNjAyNzMsImV4cCI6MTYwMTc2MDI3Mywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiZXJpY2dhbnNhQGdtYWlsLmNvbSJ9.p14Rf3DamoYkm6JocTMH9kpPL0Qb_WqEeNyxxFLi9NuvDS4hu1qTiFXrDDpDqAMpQnL8D3Xvy4yJnb1j6ji9vnQmoEHfVBzJ3BdS34O07nMdRmriOvN3LTVInSOrLlgbd4NGryfWvfxjd1LGJ86Q9-d87gqg7dop_zWqMLaTAwApRwbR9GLOQ6lv7EW74AmKR_O3xfnUzM2tdlaYZ9Wl02yQtD4qwV0raI9KiPfoDtFamgMPAQ7pc4D_Tz2i3-n0slSGM_S2VwpCZFCGuMAMl4dxOujpk-KLqqdsaU-0YT7aqeZOGKBKo9YII2DrM9TAFYEaSSX5SNhs57NWHyacH8YvzDkuVRwJG6Nq-gck2gPcB6uTogn14dIfZnoGT87fd5vWCfyB9OgLLd17bqqcACSBQoTacXElBvGEtb4VBbtjazDHtkP2Om4AghlwYZkrfDyfLjBojcTQ4zVfTGURNTnJ8zmL33VFShgoKSPi7WDddDav1f44dKkt1K_fTl1R2biVdnUtoTxYmQ3nu0Nyginjnl6tmAddqsNDh8oCapw4aoz3uF1AS8ilsX6r1A-NVW8b9l0Z1Om6AIE4J0f-ShpnUPLjjJ4HurO4hDMwqpKlbaFcj1SIkiNT8rCMYBaMN3NDAABfJfcOI-V9fowfi_fT5X7IKUHOd6ZdwsHauzk"),
 * )
 * 
 * 
 * @OA\Schema(
 *      schema="User",
 *      description="User",
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
