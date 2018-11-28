<?php

namespace PouleR\AppleMusicAPI\Request;

/**
 * Class LibraryPlaylistRequestTrack
 */
class LibraryPlaylistRequestTrack
{
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
    public function __construct($id, $type = 'songs')
    {
        $this->setId($id);
        $this->setType($type);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
