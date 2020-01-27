<?php

namespace PouleR\AppleMusicAPI\Request;

use PouleR\AppleMusicAPI\Entity\LibraryResource;

/**
 * Class LibraryPlaylistCreationRequest
 */
class LibraryPlaylistCreationRequest
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var LibraryResource[]
     */
    protected $tracks = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param LibraryResource $track
     */
    public function addTrack(LibraryResource $track): void
    {
        $this->tracks[] = $track;
    }

    /**
     * @return LibraryResource[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }
}
