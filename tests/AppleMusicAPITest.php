<?php

namespace PouleR\AppleMusicAPI\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\APIClient;
use PouleR\AppleMusicAPI\AppleMusicAPI;
use PouleR\AppleMusicAPI\Entity\LibraryResource;
use PouleR\AppleMusicAPI\Request\LibraryPlaylistCreationRequest;
use PouleR\AppleMusicAPI\Request\LibraryResourceAddRequest;

/**
 * Class AppleMusicAPITest
 */
class AppleMusicAPITest extends TestCase
{
    /**
     * @var APIClient|MockObject
     */
    private $client;

    /**
     * @var AppleMusicAPI
     */
    private $api;

    /**
     *
     */
    public function setUp(): void
    {
        $this->client = $this->createMock(APIClient::class);
        $this->api = new AppleMusicAPI($this->client);
    }

    /**
     *
     */
    public function testAPIClient(): void
    {
        self::assertEquals($this->client, $this->api->getAPIClient());
    }

    /**
     *
     */
    public function testDeveloperToken(): void
    {
        $this->client->expects(static::once())
            ->method('setDeveloperToken')
            ->with('token');

        $this->api->setDeveloperToken('token');
    }

    /**
     *
     */
    public function testMusicUserToken(): void
    {
        $this->client->expects(static::once())
            ->method('setMusicUserToken')
            ->with('x-x-x');

        $this->api->setMusicUserToken('x-x-x');
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testCatalogCharts(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/nl/charts?types=albums%2Csongs&offset=0&limit=15&genre=20')
            ->willReturn('{"OK"}');

        self::assertEquals(
            '{"OK"}',
            $this->api->getCatalogCharts('nl', ['albums', 'songs'], 20, 15)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testCatalogPlaylist(): void
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
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testCatalogAlbum(): void
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
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
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
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testCatalogArtist(): void
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

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testUsersStorefront(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'me/storefront')
            ->willReturn('us');

        self::assertEquals(
            'us',
            $this->api->getUsersStorefront()
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testRecentlyPlayedResources(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'me/recent/played?offset=5&limit=10')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->getRecentlyPlayedResources(250, 5)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAllLibraryPlaylists(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'me/library/playlists?offset=3&limit=100')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->getAllLibraryPlaylists(500, 3)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAllLibraryAlbums(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'me/library/albums?offset=0&limit=25')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->getAllLibraryAlbums()
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAllLibraryArtists(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'me/library/artists?offset=0&limit=20')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->getAllLibraryArtists(20)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAllLibraryMusicVideos(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'me/library/music-videos?offset=10&limit=10')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->getAllLibraryMusicVideos(10, 10)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testResourceToLibrary(): void
    {
        $request = new LibraryResourceAddRequest();
        $request->addSong(new LibraryResource('123'));
        $request->addSong(new LibraryResource('888'));
        $request->addAlbum(new LibraryResource('456', LibraryResource::TYPE_ALBUM));

        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('POST', 'me/library?ids[songs]=123,888&ids[albums]=456', [], ' ')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->addResourceToLibrary($request)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testCreateLibraryPlaylist(): void
    {
        $playlist = new LibraryPlaylistCreationRequest('unit.test');
        $playlist->setDescription('description');

        $track1 = new LibraryResource(5);
        $track2 = new LibraryResource(3);

        $playlist->addTrack($track1);
        $playlist->addTrack($track2);

        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with(
                'POST',
                'me/library/playlists',
                ['Content-Type' => 'application/json'],
                '{"attributes":{"name":"unit.test","description":"description"},"relationships":{"tracks":{"data":[{"id":"5","type":"songs"},{"id":"3","type":"songs"}]}}}'
            )
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->createLibraryPlaylist($playlist)
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testSearchCatalog(): void
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('GET', 'catalog/us/search?term=search&types=songs')
            ->willReturn('{"Search"}');

        self::assertEquals(
            '{"Search"}',
            $this->api->searchCatalog('us', 'search', 'songs')
        );
    }
}
