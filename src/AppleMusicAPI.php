<?php

namespace PouleR\AppleMusicAPI;

/**
 * Class AppleMusicAPI
 */
class AppleMusicAPI
{
    /**
     * @var APIClient
     */
    protected $client;

    /**
     * @param APIClient $client
     */
    public function __construct(APIClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return APIClient
     */
    public function getAPIClient()
    {
        return $this->client;
    }

    /**
     * @param string $developerToken
     */
    public function setDeveloperToken($developerToken)
    {
        $this->client->setDeveloperToken($developerToken);
    }

    /**
     * @param string $musicUserToken
     */
    public function setMusicUserToken($musicUserToken)
    {
        $this->client->setMusicUserToken($musicUserToken);
    }

    /**
     * Fetch one or more charts from the Apple Music Catalog.
     * https://developer.apple.com/documentation/applemusicapi/get_catalog_charts
     *
     * @param string $storefront An iTunes Store territory, specified by an ISO 3166 alpha-2 country code.
     * @param array  $types The possible values are albums, songs, and music-videos
     * @param int    $limit The number of resources to include per chart. The default value is 20 and the maximum value is 50.
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getCatalogCharts($storefront, $types = [], $limit = 20)
    {
        $queryString = http_build_query([
                'types' => implode(',', $types),
                'limit' => $limit,
            ]);

        $requestUrl = sprintf('catalog/%s/charts?%s', $storefront, $queryString);

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch a playlist by using its identifier.
     * https://developer.apple.com/documentation/applemusicapi/get_a_catalog_playlist
     *
     * @param string $storefront An iTunes Store territory, specified by an ISO 3166 alpha-2 country code.
     * @param string $playlistId The unique identifier for the playlist.
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getCatalogPlaylist($storefront, $playlistId)
    {
        $requestUrl = sprintf('catalog/%s/playlists/%s', $storefront, $playlistId);

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch an album by using its identifier.
     * https://developer.apple.com/documentation/applemusicapi/get_a_catalog_album
     *
     * @param string $storefront An iTunes Store territory, specified by an ISO 3166 alpha-2 country code.
     * @param string $albumId The unique identifier for the album.
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getCatalogAlbum($storefront, $albumId)
    {
        $requestUrl = sprintf('catalog/%s/albums/%s', $storefront, $albumId);

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch a song by using its identifier.
     * https://developer.apple.com/documentation/applemusicapi/get_a_catalog_song
     *
     * @param string $storefront An iTunes Store territory, specified by an ISO 3166 alpha-2 country code.
     * @param string $songId The unique identifier for the song.
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getCatalogSong($storefront, $songId)
    {
        $requestUrl = sprintf('catalog/%s/songs/%s', $storefront, $songId);

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch an artist by using the artist's identifier.
     * https://developer.apple.com/documentation/applemusicapi/get_a_catalog_artist
     *
     * @param string $storefront An iTunes Store territory, specified by an ISO 3166 alpha-2 country code.
     * @param string $artistId The unique identifier for the artist.
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getCatalogArtist($storefront, $artistId)
    {
        $requestUrl = sprintf('catalog/%s/artists/%s', $storefront, $artistId);

        return $this->client->apiRequest('GET', $requestUrl);
    }
}
