<?php

namespace PouleR\AppleMusicAPI\Tests;

use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\APIClient;
use PouleR\AppleMusicAPI\AppleMusicAPI;

/**
 * Class AppleMusicAPITest
 */
class AppleMusicAPITest extends TestCase
{
    /**
     * @var APIClient|\PHPUnit_Framework_MockObject_MockObject
     */
    private $client;

    /**
     * @var AppleMusicAPI
     */
    private $api;

    /**
     *
     */
    public function setUp()
    {
        $this->client = $this->createMock(APIClient::class);
        $this->api = new AppleMusicAPI($this->client);
    }

    /**
     *
     */
    public function testAPIClient()
    {
        self::assertEquals($this->client, $this->api->getAPIClient());
    }

    /**
     *
     */
    public function testDeveloperToken()
    {
        $this->client->expects(static::once())
            ->method('setDeveloperToken')
            ->with('token');

        $this->api->setDeveloperToken('token');
    }

    /**
     *
     */
    public function testMusicUserToken()
    {
        $this->client->expects(static::once())
            ->method('setMusicUserToken')
            ->with('x-x-x');

        $this->api->setMusicUserToken('x-x-x');
    }

    /**
     *
     */
    public function testCatalogCharts()
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/nl/charts?types=albums%2Csongs&limit=15')
            ->willReturn('{"OK"}');

        self::assertEquals(
            '{"OK"}',
            $this->api->getCatalogCharts('nl', ['albums', 'songs'], 15)
        );
    }

    /**
     *
     */
    public function testCatalogPlaylist()
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/us/playlists/pl.12345')
            ->willReturn('{"OK"}');

        self::assertEquals(
            '{"OK"}',
            $this->api->getCatalogPlaylist('us', 'pl.12345')
        );
    }

    /**
     *
     */
    public function testCatalogAlbum()
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/us/albums/test')
            ->willReturn('{"OK"}');

        self::assertEquals(
            '{"OK"}',
            $this->api->getCatalogAlbum('us', 'test')
        );
    }

    /**
     *
     */
    public function testCatalogSong()
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/us/songs/song.id')
            ->willReturn('{"OK"}');

        self::assertEquals(
            '{"OK"}',
            $this->api->getCatalogSong('us', 'song.id')
        );
    }

    /**
     *
     */
    public function testCatalogArtist()
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/us/artists/artist.id')
            ->willReturn('{"OK"}');

        self::assertEquals(
            '{"OK"}',
            $this->api->getCatalogArtist('us', 'artist.id')
        );
    }
}
