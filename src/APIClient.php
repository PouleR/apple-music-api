<?php

namespace PouleR\AppleMusicAPI;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class APIClient
  */
class APIClient
{
    const APPLEMUSIC_API_URL = 'https://api.music.apple.com/v1';

    /**
     * Return types for json_decode
     */
    const RETURN_AS_OBJECT = 0;
    const RETURN_AS_ASSOC = 1;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $developerToken = '';

    /**
     * @var string
     */
    protected $musicUserToken = '';

    /**
     * @var int
     */
    protected $lastHttpStatusCode = 0;

    /**
     * @var
     */
    protected $responseType = self::RETURN_AS_OBJECT;

    /**
     * APIClient constructor.
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $developerToken
     */
    public function setDeveloperToken(string $developerToken): void
    {
        $this->developerToken = $developerToken;
    }

    /**
     * @return string
     */
    public function getDeveloperToken(): string
    {
        return $this->developerToken;
    }

    /**
     * @param string $musicUserToken
     */
    public function setMusicUserToken(string $musicUserToken): void
    {
        $this->musicUserToken = $musicUserToken;
    }

    /**
     * @param string                                      $method
     * @param string                                      $service
     * @param array                                       $headers
     * @param array|string|resource|\Traversable|\Closure $body
     *
     * @return array|object
     *
     * @throws AppleMusicAPIException
     */
    public function apiRequest($method, $service, array $headers = [], $body = null)
    {
        $url = sprintf(
            '%s/%s',
            self::APPLEMUSIC_API_URL,
            $service
        );

        $authorizationHeaders = $this->setAuthorizationHeaders();
        $headers = array_merge($headers, $authorizationHeaders);

        try {
            $response = $this->httpClient->request($method, $url, ['headers' => $headers, 'body' => $body]);
            $this->lastHttpStatusCode = $response->getStatusCode();

            return json_decode($response->getContent(), $this->responseType === self::RETURN_AS_ASSOC);
        } catch (ServerExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | TransportExceptionInterface $exception) {
            throw new AppleMusicAPIException(
                sprintf(
                    'API Request: %s, %s (%s)',
                    $service,
                    $exception->getMessage(),
                    $exception->getCode()
                ),
                $exception->getCode()
            );
        }
    }

    /**
     * @return int
     */
    public function getLastHttpStatusCode(): int
    {
        return $this->lastHttpStatusCode;
    }

    /**
     * @param int $responseType
     */
    public function setResponseType($responseType): void
    {
        $this->responseType = $responseType;
    }
    /**
     * @return int
     */
    public function getResponseType(): int
    {
        return $this->responseType;
    }

    /**
     * @return array
     */
    protected function setAuthorizationHeaders(): array
    {
        $authorizationHeaders = [
            'Authorization' => 'Bearer ' . $this->developerToken,
        ];

        if (!empty($this->musicUserToken)) {
            $authorizationHeaders['Music-User-Token'] = $this->musicUserToken;
        }

        return $authorizationHeaders;
    }
}
