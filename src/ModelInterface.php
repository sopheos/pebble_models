<?php

namespace Pebble\Models;

interface ModelInterface extends \JsonSerializable
{
    /**
     * Initialize data
     */
    public function init(): static;

    /**
     * Imports data
     *
     * @param array $data
     * @return static
     */
    public function import(array $data = []): static;

    /**
     * Exports data
     *
     * @return array
     */
    public function export(): array;

    /**
     * Get all properties
     *
     * @return array
     */
    public function properties(): array;
}
