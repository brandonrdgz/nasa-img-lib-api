<?php

namespace App\Models;

use ArrayAccess;

class ImageGalleryList implements ArrayAccess
{
    protected $container = [];

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->offsetExists($offset) ?
            $this->container[$offset] :
            null;
    }

    public function offsetSet($offset, $value): void
    {
        if(is_null($offset)) {
            array_push($this->container, $value);
        }
        else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    public function __serialize(): array
    {
        return $this->container;
    }
}