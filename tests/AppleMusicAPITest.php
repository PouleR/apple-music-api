<?php

namespace PouleR\AppleMusicAPI\Tests;

use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\APIClient;
use PouleR\AppleMusicAPI\AppleMusicAPI;
use PouleR\AppleMusicAPI\Request\LibraryPlaylistCreationRequest;
use PouleR\AppleMusicAPI\Request\LibraryPlaylistRequestTrack;

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
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
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
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
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
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
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

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testUsersStorefront()
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
    public function testRecentlyPlayedResources()
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
    public function testAllLibraryPlaylists()
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
    public function testAllLibraryAlbums()
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
    public function testAllLibraryArtists()
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
    public function testAllLibraryMusicVideos()
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
    public function testResourceToLibrary()
    {
        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with('POST', 'me/library?ids[0]=1&ids[1]=2&ids[2]=3', [], ' ')
            ->willReturn('OK');

        self::assertEquals(
            'OK',
            $this->api->addResourceToLibrary([1, 2, 3])
        );
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testCreateLibraryPlaylist()
    {
        $playlist = new LibraryPlaylistCreationRequest('unit.test');
        $playlist->setDescription('description');

        $track1 = new LibraryPlaylistRequestTrack(5);
        $track2 = new LibraryPlaylistRequestTrack(3);

        $playlist->addTrack($track1);
        $playlist->addTrack($track2);

        $this->client->expects(static::once())
            ->method('apiRequest')
            ->with(
                'POST',
                'me/library/playlists',
                ['Content-Type' => 'application/json'],
                '{"attributes":{"name":"unit.test","description":"description"},"relationships":{"tracks":{"data":[{"id":5,"type":"songs"},{"id":3,"type":"songs"}]}}}'
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
    public function testSearchCatalog()
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
