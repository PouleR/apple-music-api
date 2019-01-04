<?php

namespace PouleR\AppleMusicAPI;

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

/**
 * Class AppleMusicAPITokenGenerator
 */
final class AppleMusicAPITokenGenerator
{
    public const MAX_EXP_DAYS = 30;
    private const TOKEN_TYPE = 'JWT';
    private const TOKEN_ALG = 'ES256';

    /**
     * @param string $teamId
     * @param string $keyId
     * @param string $keyFile
     * @param int    $expirationDays
     *
     * @return null|string
     */
    public static function generateDeveloperToken($teamId, $keyId, $keyFile, $expirationDays = self::MAX_EXP_DAYS)
    {
        $time = time();

        $payload = [
            'iat' => $time,
            'exp' => $time + (max($expirationDays, self::MAX_EXP_DAYS) * 86400),
            'iss' => $teamId,
        ];

        $headers = [
            'alg' => self::TOKEN_ALG,
            'typ' => self::TOKEN_TYPE,
            'kid' => $keyId,
        ];

        try {
            $jsonConverter = new StandardConverter();
            $algorithmManager = AlgorithmManager::create([
                new ES256(),
            ]);

            $jwsBuilder = new JWSBuilder(
                $jsonConverter,
                $algorithmManager
            );

            $signatureKey = JWKFactory::createFromKeyFile($keyFile);
            $jws = $jwsBuilder
                ->create()
                ->withPayload($jsonConverter->encode($payload))
                ->addSignature($signatureKey, $headers)
                ->build();

            $serializer = new CompactSerializer($jsonConverter);

            return $serializer->serialize($jws);
        } catch (\Exception $exception) {
            //Ignore
        }

        return null;
    }
}
