<?php

namespace PouleR\AppleMusicAPI\Request;

use PouleR\AppleMusicAPI\AppleMusicAPIException;
use PouleR\AppleMusicAPI\Entity\LibraryResource;

/**
 * Class LibraryResourceAddRequest
 */
class LibraryResourceAddRequest
{
    /**
     * @var LibraryResource[]
     */
    protected $songs = [];

    /**
     * @var LibraryResource[]
     */
    protected $albums = [];

    /**
     * @var LibraryResource[]
     */
    protected $musicVideos = [];

    /**
     * @var LibraryResource[]
     */
    protected $playlists = [];

    /**
     * @param LibraryResource $song
     *
     * @throws AppleMusicAPIException
     */
    public function addSong(LibraryResource $song): void
    {
        if ($song->getType() !== LibraryResource::TYPE_SONG) {
            $this->throwInvalidTypeException('song', $song);
        }

        $this->songs[] = $song;
    }

    /**
     * @param LibraryResource $album
     *
     * @throws AppleMusicAPIException
     */
    public function addAlbum(LibraryResource $album): void
    {
        if ($album->getType() !== LibraryResource::TYPE_ALBUM) {
            $this->throwInvalidTypeException('album', $album);
        }

        $this->albums[] = $album;
    }

    /**
     * @param LibraryResource $musicVideo
     *
     * @throws AppleMusicAPIException
     */
    public function addMusicVideo(LibraryResource $musicVideo): void
    {
        if ($musicVideo->getType() !== LibraryResource::TYPE_MUSICVIDEO) {
            $this->throwInvalidTypeException('music-video', $musicVideo);
        }

        $this->musicVideos[] = $musicVideo;
    }

    /**
     * @param LibraryResource $playlist
     *
     * @throws AppleMusicAPIException
     */
    public function addPlaylist(LibraryResource $playlist): void
    {
        if ($playlist->getType() !== LibraryResource::TYPE_PLAYLIST) {
            $this->throwInvalidTypeException('playlist', $playlist);
        }

        $this->playlists[] = $playlist;
    }

    /**
     * @return LibraryResource[]
     */
    public function getSongs(): array
    {
        return $this->songs;
    }

    /**
     * @return LibraryResource[]
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    /**
     * @return LibraryResource[]
     */
    public function getMusicVideos(): array
    {
        return $this->musicVideos;
    }

    /**
     * @return LibraryResource[]
     */
    public function getPlaylists(): array
    {
        return $this->playlists;
    }

    /**
     * @param string          $type
     * @param LibraryResource $resource
     *
     * @throws AppleMusicAPIException
     */
    private function throwInvalidTypeException($type, LibraryResource $resource)
    {
        throw new AppleMusicAPIException(
            sprintf(
                'Invalid type given for a %s, type: %s, id: %s',
                $type,
                $resource->getType(),
                $resource->getId()
            )
        );
    }
}
