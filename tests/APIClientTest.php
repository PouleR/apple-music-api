<?php

namespace PouleR\AppleMusicAPI\Tests;

use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\APIClient;
use PouleR\AppleMusicAPI\AppleMusicAPIException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * Class APIClientTest
  */
class APIClientTest extends TestCase
{
    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAPIRequestDeveloperToken(): void
    {
        $mockResponse = new MockResponse('{"id": "12345","title": "OnlyDevToken"}');
        $httpClient = new MockHttpClient([$mockResponse]);
        $apiClient = new APIClient($httpClient);

        $apiClient->setDeveloperToken('dev.token');
        $response = $apiClient->apiRequest('GET', 'catalog/1/playlists/2');

        $requestOptions = $mockResponse->getRequestOptions();
        self::assertContains('Authorization: Bearer dev.token', $requestOptions['headers']);
        self::assertEquals('12345', $response->id);
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAPIRequestMusicUserToken(): void
    {
        $mockResponse = new MockResponse('{"id": "12345","title": "UserToken"}');
        $httpClient = new MockHttpClient([$mockResponse]);
        $apiClient = new APIClient($httpClient);
        $apiClient->setDeveloperToken('dev.token');
        $apiClient->setMusicUserToken('user.token');

        $response = $apiClient->apiRequest('GET', 'catalog/2/playlists/3');
        $requestOptions = $mockResponse->getRequestOptions();

        self::assertContains('Authorization: Bearer dev.token', $requestOptions['headers']);
        self::assertContains('Music-User-Token: user.token', $requestOptions['headers']);
        self::assertEquals('UserToken', $response->title);
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAPIRequestException(): void
    {
        $callback = function () {
            throw new TransportException('Whoops', 500);
        };

        $httpClient = new MockHttpClient($callback);
        $apiClient = new APIClient($httpClient);

        $apiClient->setDeveloperToken('dev.token');

        $this->expectException(AppleMusicAPIException::class);
        $this->expectExceptionMessage('API Request: test, Whoops');
        $this->expectExceptionCode(500);

        $apiClient->apiRequest('GET', 'test');
    }

    /**
     *
     */
    public function testResponseType(): void
    {
        $httpClient = new MockHttpClient();
        $apiClient = new APIClient($httpClient);
        self::assertEquals(APIClient::RETURN_AS_OBJECT, $apiClient->getResponseType());

        $apiClient->setResponseType(APIClient::RETURN_AS_ASSOC);
        self::assertEquals(APIClient::RETURN_AS_ASSOC, $apiClient->getResponseType());
    }
}
