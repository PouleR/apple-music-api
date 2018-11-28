<?php

namespace PouleR\AppleMusicAPI\Request;

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
     * @var LibraryPlaylistRequestTrack[]
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
    public function setName(string $name)
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
    public function setDescription(string $description)
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
     * @param LibraryPlaylistRequestTrack $track
     */
    public function addTrack(LibraryPlaylistRequestTrack $track)
    {
        $this->tracks[] = $track;
    }

    /**
     * @return LibraryPlaylistRequestTrack[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }
}
