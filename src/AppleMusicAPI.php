<?php

namespace PouleR\AppleMusicAPI;

use PouleR\AppleMusicAPI\Request\LibraryPlaylistCreationRequest;

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
     * @param int    $limit The number of resources to include per chart.
     *                      The default value is 20 and the maximum value is 50.
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

    /**
     * Fetch a user’s storefront.
     * https://developer.apple.com/documentation/applemusicapi/get_a_user_s_storefront
     *     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getUsersStorefront()
    {
        return $this->client->apiRequest('GET', 'me/storefront');
    }

    /**
     * Fetch the recently played resources for the user.
     * https://developer.apple.com/documentation/applemusicapi/get_recently_played_resources
     *     *
     * @param int $limit The limit on the number of objects, or number of objects in the specified relationship,
     *                   that are returned.
     * @param int $offset The next page or group of objects to fetch.
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getRecentlyPlayedResources($limit = 5, $offset = 0)
    {
        $requestUrl = sprintf('me/recent/played?%s', $this->getLimitOffsetQueryString($limit, $offset, 10));

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch all the library playlists in alphabetical order.
     * https://developer.apple.com/documentation/applemusicapi/get_all_library_playlists
     *
     * @param int $limit
     * @param int $offset
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getAllLibraryPlaylists($limit = 25, $offset = 0)
    {
        $requestUrl = sprintf('me/library/playlists?%s', $this->getLimitOffsetQueryString($limit, $offset));

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch all the library albums in alphabetical order.
     * https://developer.apple.com/documentation/applemusicapi/get_all_library_albums
     *
     * @param int $limit
     * @param int $offset
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getAllLibraryAlbums($limit = 25, $offset = 0)
    {
        $requestUrl = sprintf('me/library/albums?%s', $this->getLimitOffsetQueryString($limit, $offset));

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch all the library artists in alphabetical order.
     * https://developer.apple.com/documentation/applemusicapi/get_all_library_artists
     *
     * @param int $limit
     * @param int $offset
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getAllLibraryArtists($limit = 25, $offset = 0)
    {
        $requestUrl = sprintf('me/library/artists?%s', $this->getLimitOffsetQueryString($limit, $offset));

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Fetch all the library music videos in alphabetical order.
     * https://developer.apple.com/documentation/applemusicapi/get_all_library_music_videos
     *
     * @param int $limit
     * @param int $offset
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function getAllLibraryMusicVideos($limit = 25, $offset = 0)
    {
        $requestUrl = sprintf('me/library/music-videos?%s', $this->getLimitOffsetQueryString($limit, $offset));

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * Add a catalog resource to a user’s iCloud Music Library.
     * https://developer.apple.com/documentation/applemusicapi/add_a_resource_to_a_library
     *
     * @param array $ids The unique catalog identifiers for the resources.
     *                   To indicate the type of resource to be added, ids must be followed
     *                   by one of the allowed values.
     *                   Multiple types can be added in the same request.
     *                   Possible values: albums, music-videos, playlists, songs
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function addResourceToLibrary($ids)
    {
        $queryString = http_build_query([
            'ids' => $ids,
        ]);

        $requestUrl = sprintf('me/library?%s', urldecode($queryString));

        return $this->client->apiRequest('POST', $requestUrl, [], ' ');
    }

    /**
     * @param LibraryPlaylistCreationRequest $playlist
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function createLibraryPlaylist(LibraryPlaylistCreationRequest $playlist)
    {
        $requestBody['attributes'] = [
            'name' => $playlist->getName(),
            'description' => $playlist->getDescription(),
        ];

        foreach ($playlist->getTracks() as $track) {
            $requestBody['relationships']['tracks']['data'][] = [
                'id' => $track->getId(),
                'type' => $track->getType(),
            ];
        }

        return $this->client->apiRequest(
            'POST',
            'me/library/playlists',
            [
                'Content-Type' => 'application/json',
            ],
            json_encode($requestBody)
        );
    }
    
    /**
     * Search for a catalog resource
     * https://developer.apple.com/documentation/applemusicapi/search_for_catalog_resources
     * https://api.music.apple.com/v1/catalog/us/search?term=caldonia&types=songs
     *
     * @param string $storefront An iTunes Store territory, specified by an ISO 3166 alpha-2 country code.
     * @param string $searchTerm The entered text for the search with ‘+’ characters between each word,
     *                           to replace spaces
     * @param string $searchTypes The list of the types of resources to include in the results. artists,albums,songs
     *
     * @return object
     *
     * @throws AppleMusicAPIException
     */
    public function searchCatalog($storefront, $searchTerm, $searchTypes)
    {
        $requestUrl = sprintf('catalog/%s/search?term=%s&types=%s', $storefront, $searchTerm, $searchTypes);

        return $this->client->apiRequest('GET', $requestUrl);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param int $maxLimit
     *
     * @return string
     */
    private function getLimitOffsetQueryString($limit, $offset, $maxLimit = 100)
    {
        return http_build_query([
            'offset' => $offset,
            'limit' => min($limit, $maxLimit),
        ]);
    }
}
