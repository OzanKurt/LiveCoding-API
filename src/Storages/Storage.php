<?php

namespace Kurt\LiveCoding\Storages;

abstract class Storage
{
    protected $text;

    public function getText()
    {
        return $this->text;
    }
}
