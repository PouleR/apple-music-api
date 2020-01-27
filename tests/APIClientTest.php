<?php

namespace PouleR\AppleMusicAPI\Tests;

use GuzzleHttp\Psr7\Response;
use Http\Message\RequestFactory;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\APIClient;
use PouleR\AppleMusicAPI\AppleMusicAPIException;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Class APIClientTest
  */
class APIClientTest extends TestCase
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var APIClient
     */
    private $client;

    /**
     *
     */
    public function setUp(): void
    {
        $this->httpClient = new Client();
        $this->client = new APIClient($this->httpClient);
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAPIRequestDeveloperToken(): void
    {
        $this->client->setDeveloperToken('dev.token');
        $this->httpClient->addResponse(new Response(200, [], '{"id": "12345","title": "OnlyDevToken"}'));

        $response = $this->client->apiRequest('GET', 'catalog/1/playlists/2');
        self::assertInstanceOf(\stdClass::class, $response);

        $requests = $this->httpClient->getRequests();
        self::assertCount(1, $requests);
        self::assertEquals('GET', $requests[0]->getMethod());
        self::assertEquals('api.music.apple.com', $requests[0]->getUri()->getHost());
        self::assertEquals('/v1//catalog/1/playlists/2', $requests[0]->getRequestTarget());
        self::assertEquals(['Bearer dev.token'], $requests[0]->getHeader('Authorization'));
        self::assertEmpty($requests[0]->getHeader('Music-User-Token'));
        self::assertEquals('12345', $response->id);
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAPIRequestMusicUserToken(): void
    {
        $this->client->setDeveloperToken('dev.token');
        $this->client->setMusicUserToken('user.token');

        $this->httpClient->addResponse(new Response(200, [], '{"id": "12345","title": "UserToken"}'));
        $response = $this->client->apiRequest('GET', 'catalog/2/playlists/3');

        $requests = $this->httpClient->getRequests();
        self::assertCount(1, $requests);
        self::assertEquals('GET', $requests[0]->getMethod());
        self::assertEquals('api.music.apple.com', $requests[0]->getUri()->getHost());
        self::assertEquals('/v1//catalog/2/playlists/3', $requests[0]->getRequestTarget());
        self::assertEquals(['Bearer dev.token'], $requests[0]->getHeader('Authorization'));
        self::assertEquals(['user.token'], $requests[0]->getHeader('Music-User-Token'));
        self::assertEquals('UserToken', $response->title);
    }

    /**
     *
     */
    public function testAPIRequestException(): void
    {
        $this->client->setDeveloperToken('dev.token');
        $this->httpClient->addException(new \Exception('Whoops', 500));

        $this->expectException(AppleMusicAPIException::class);
        $this->expectExceptionMessage('API Request: test, Whoops');
        $this->expectExceptionCode(500);

        $this->client->apiRequest('GET', 'test');
    }

    /**
     *
     */
    public function testResponseType(): void
    {
        self::assertEquals(APIClient::RETURN_AS_OBJECT, $this->client->getResponseType());

        $this->client->setResponseType(APIClient::RETURN_AS_ASSOC);
        self::assertEquals(APIClient::RETURN_AS_ASSOC, $this->client->getResponseType());
    }
}
