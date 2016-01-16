<?php

namespace Kurt\LiveCoding\Utilities;

class FileManager
{
    /**
     * [exists description].
     * 
     * @param [type] $path
     *
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($path);
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
        return file_get_contents($path);
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
        file_put_contents($path, $value);
    }
}
