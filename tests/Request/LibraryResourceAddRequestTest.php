<?php

namespace PouleR\AppleMusicAPI\Tests\Request;

use PHPUnit\Framework\TestCase;
use PouleR\AppleMusicAPI\AppleMusicAPIException;
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
    public function setUp(): void
    {
        $this->addRequest = new LibraryResourceAddRequest();
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testSongsException(): void
    {
        $this->expectException(AppleMusicAPIException::class);
        $this->addRequest->addSong(new LibraryResource('invalid',LibraryResource::TYPE_ALBUM));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testSongs(): void
    {
        $this->addRequest->addSong(new LibraryResource('song1'));
        $this->addRequest->addSong(new LibraryResource('song2'));
        self::assertCount(2, $this->addRequest->getSongs());
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAlbumsException(): void
    {
        $this->expectException(AppleMusicAPIException::class);
        $this->addRequest->addAlbum(new LibraryResource('invalid'));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testAlbums(): void
    {
        $this->addRequest->addAlbum(new LibraryResource('album3', LibraryResource::TYPE_ALBUM));
        self::assertEquals('album3', $this->addRequest->getAlbums()[0]->getId());
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testPlaylistsException(): void
    {
        $this->expectException(AppleMusicAPIException::class);
        $this->addRequest->addPlaylist(new LibraryResource('invalid', LibraryResource::TYPE_MUSICVIDEO));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testPlaylists(): void
    {
        $this->addRequest->addPlaylist(new LibraryResource('play-list', LibraryResource::TYPE_PLAYLIST));
        self::assertCount(1, $this->addRequest->getPlaylists());
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testMusicVideosException(): void
    {
        $this->expectException(AppleMusicAPIException::class);
        $this->addRequest->addMusicVideo(new LibraryResource('invalid', LibraryResource::TYPE_PLAYLIST));
    }

    /**
     * @throws \PouleR\AppleMusicAPI\AppleMusicAPIException
     */
    public function testMusicVideos(): void
    {
        $this->addRequest->addMusicVideo(new LibraryResource('video', LibraryResource::TYPE_MUSICVIDEO));
        self::assertCount(1, $this->addRequest->getMusicVideos());
    }
}
