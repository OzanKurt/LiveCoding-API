<?php

namespace Kurt\LiveCoding\Storages;

class FileStorage extends Storage
{
    protected $path;

    public function __construct($path = null)
    {
        if (is_null($path)) {
            throw new \Exception('Storage path cannot be null.');
        }
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }
}
