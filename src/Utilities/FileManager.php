<?php

namespace Kurt\LiveCoding\Utilities;

class FileManager
{
    /**
     * [$basePath description]
     * @var [type]
     */
    protected $basePath;

    /**
     * [__construct description]
     * 
     * @param [type] $basePath [description]
     */
    public function __construct($basePath) {
        $this->basePath = $basePath;
    }

    /**
     * [exists description].
     * 
     * @param [type] $path
     *
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($this->getPathTo($path));
    }

    /**
     * [get description].
     * 
     * @param [type] $path
     *
     * @return [type]
     */
    public function get($path)
    {
        return file_get_contents($this->getPathTo($path));
    }

    /**
     * [put description].
     * 
     * @param [type] $path
     * @param [type] $value
     *
     * @return [type]
     */
    public function put($path, $value)
    {
        file_put_contents($this->getPathTo($path), $value);
    }

    public function getPathTo($path)
    {
        return $this->basePath.'/'.$path;
    }
}
