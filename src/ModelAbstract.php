<?php

namespace Pebble\Models;

abstract class ModelAbstract implements ModelInterface
{
    // -------------------------------------------------------------------------

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->init();
        $this->import($data);
    }

    /**
     * @param array $data
     * @return \static
     */
    public static function create(array $data = [])
    {
        return new static($data);
    }

    // -------------------------------------------------------------------------

    /**
     * Initialize data
     */
    public function init(): static
    {
        return $this;
    }

    /**
     * Imports data
     *
     * @param array $data
     * @return static
     */
    public function import(array $data = []): static
    {
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }

        return $this;
    }

    /**
     * Exports data
     *
     * @return array
     */
    public function export(): array
    {
        return json_decode(json_encode($this), true) ?? [];
    }

    /**
     * Get all properties
     *
     * @return array
     */
    public function properties(): array
    {
        return Reflection::getInstance($this::class)->properties();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        $data = [];
        foreach ($this->properties() as $key) {
            $data[$key] = $this->{$key};
        }

        return $data;
    }

    public function __set($name, $value) {}
}
