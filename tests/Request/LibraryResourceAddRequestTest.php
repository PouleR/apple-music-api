<?php

namespace PouleR\AppleMusicAPI\Tests\Request;

use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\Entity\LibraryResource;
use PouleR\AppleMusicAPI\Request\LibraryResourceAddRequest;

/**
 * Class LibraryResourceAddRequestTest
 */
class LibraryResourceAddRequestTest extends TestCase
{
    /**
     * @var LibraryResourceAddRequest
     */
    private $addRequest;

    /**
     *
     */
    public function setUp()
    {
        $this->addRequest = new LibraryResourceAddRequest();
    }

    /**
     * @expectedException \PouleR\AppleMusicAPI\AppleMusicAPIException
     *
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testSongsException()
    {
        $this->addRequest->addSong(new LibraryResource('invalid',LibraryResource::TYPE_ALBUM));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testSongs()
    {
        $this->addRequest->addSong(new LibraryResource('song1'));
        $this->addRequest->addSong(new LibraryResource('song2'));
        self::assertCount(2, $this->addRequest->getSongs());
    }

    /**
     * @expectedException \PouleR\AppleMusicAPI\AppleMusicAPIException
     *
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAlbumsException()
    {
        $this->addRequest->addAlbum(new LibraryResource('invalid'));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAlbums()
    {
        $this->addRequest->addAlbum(new LibraryResource('album3', LibraryResource::TYPE_ALBUM));
        self::assertEquals('album3', $this->addRequest->getAlbums()[0]->getId());
    }

    /**
     * @expectedException \PouleR\AppleMusicAPI\AppleMusicAPIException
     *
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testPlaylistsException()
    {
        $this->addRequest->addPlaylist(new LibraryResource('invalid', LibraryResource::TYPE_MUSICVIDEO));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testPlaylists()
    {
        $this->addRequest->addPlaylist(new LibraryResource('play-list', LibraryResource::TYPE_PLAYLIST));
        self::assertCount(1, $this->addRequest->getPlaylists());
    }

    /**
     * @expectedException \PouleR\AppleMusicAPI\AppleMusicAPIException
     *
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testMusicVideosException()
    {
        $this->addRequest->addMusicVideo(new LibraryResource('invalid', LibraryResource::TYPE_PLAYLIST));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testMusicVideos()
    {
        $this->addRequest->addMusicVideo(new LibraryResource('video', LibraryResource::TYPE_MUSICVIDEO));
        self::assertCount(1, $this->addRequest->getMusicVideos());
    }
}
