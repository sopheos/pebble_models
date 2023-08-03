<?php

namespace Pebble\Models;

abstract class AdapterAbstract implements AdapterInterface
{
    /**
     * Encode data model for a store
     *
     * @param mixed $input
     * @return mixed
     */
    public function encode(mixed $input): mixed
    {
        return $input;
    }

    /**
     * Decode data model from a store
     *
     * @param mixed $input
     * @return mixed
     */
    public function decode(mixed $input): mixed
    {
        return $input;
    }

    /**
     * Return the unique values from a single column in the input array
     *
     * @param array $rows
     * @param string $property
     * @return array
     */
    public static function unique(array $rows, string $property): array
    {
        return array_values(array_unique(array_column($rows, $property)));
    }
}
