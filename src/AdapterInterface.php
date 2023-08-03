<?php

namespace Pebble\Models;

interface AdapterInterface
{
    /**
     * Encode data model for a store
     *
     * @param mixed $input
     * @return mixed
     */
    public function encode(mixed $input): mixed;

    /**
     * Decode data model from a store
     *
     * @param mixed $input
     * @return mixed
     */
    public function decode(mixed $input): mixed;
}
