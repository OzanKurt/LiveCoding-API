<?php

namespace Kurt\LiveCoding\Storages;

use Kurt\LiveCoding\AuthTokens\FileAuthToken;
use Kurt\LiveCoding\Exceptions\InvalidPathException;
use Kurt\LiveCoding\Utilities\FileManager;

/**
 * Class FileStorage
 * @package Kurt\LiveCoding\Storages
 */
class FileStorage extends Storage
{
    protected $fileManager;

    /**
     * [__construct description].
     *
     * @param string $path
     */
    public function __construct($path = null)
    {
        $this->initializeFileManager($path);

        $this->initializeAuthToken();
    }

    /**
     * Initialize FileManager for AuthToken instance.
     *
     * @param $path
     *
     * @throws \Kurt\LiveCoding\Exceptions\InvalidPathException
     */
    private function initializeFileManager($path)
    {
        if (is_null($path)) {
            throw new InvalidPathException();
        }

        $this->fileManager = new FileManager($path);
    }

    /**
     * Initialize AuthToken instance related to the storage.
     *
     * @return void
     */
    protected function initializeAuthToken()
    {
        $this->authToken = new FileAuthToken($this->fileManager);
    }
}
