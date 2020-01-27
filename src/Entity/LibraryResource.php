<?php

namespace PouleR\AppleMusicAPI\Entity;

/**
 * Class LibraryResource
 */
class LibraryResource
{
    public const TYPE_SONG = 'songs';
    public const TYPE_ALBUM = 'albums';
    public const TYPE_PLAYLIST = 'playlists';
    public const TYPE_MUSICVIDEO = 'music-videos';

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @param string $id
     * @param string $type
     */
    public function __construct($id, $type = self::TYPE_SONG)
    {
        $this->setId($id);
        $this->setType($type);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
}
