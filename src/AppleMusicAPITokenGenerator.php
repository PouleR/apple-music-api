<?php

namespace PouleR\AppleMusicAPI;

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;

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
            $key = JWKFactory::createFromKeyFile($keyFile);

            return JWSFactory::createJWSToCompactJSON($payload, $key, $headers);
        } catch (\Exception $exception) {

        }

        return null;
    }
}
