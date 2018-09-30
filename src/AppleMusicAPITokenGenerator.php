<?php

namespace PouleR\AppleMusicAPI;

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;

/**
 * Class AppleMusicAPITokenGenerator
 */
final class AppleMusicAPITokenGenerator
{
    const TOKEN_TYPE = 'JWT';
    const TOKEN_ALG = 'ES256';

    /**
     * @param string $teamId
     * @param string $keyId
     * @param string $keyFile
     * @param int    $expiration
     *
     * @return string
     */
    public static function generateToken($teamId, $keyId, $keyFile, $expiration = 30)
    {
        $payload = [
            'iss' => $teamId,
            'exp' => time() + ($expiration * 86400),
            'ait' => time(),
        ];

        $headers = [
            'alg' => self::TOKEN_ALG,
            'type' => self::TOKEN_TYPE,
            'kid' => $keyId
        ];

        $key = JWKFactory::createFromKeyFile($keyFile);

        return JWSFactory::createJWSToCompactJSON($payload, $key, $headers);
    }
}
