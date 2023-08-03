<?php

namespace Pebble\Models;

use InvalidArgumentException;

abstract class JsonFile
{
    private static array $instances = [];
    protected array $data = [];

    // -------------------------------------------------------------------------

    /**
     * @param string $file
     */
    protected function __construct()
    {
        $filename = $this->filename();

        if (!is_file($filename)) {
            throw new InvalidArgumentException("{$filename} not found");
        }

        $this->data = json_decode(file_get_contents($filename), true);
    }

    /**
     * Nom du fichier
     *
     * @return string
     */
    abstract protected function filename(): string;

    /**
     * @return static
     */
    public static function create(): static
    {
        $key = static::class;

        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new static();
        }

        return self::$instances[$key];
    }

    // -------------------------------------------------------------------------

    public function save(array $data): static
    {
        static::sort($data);
        $this->data = $data;

        file_put_contents(
            $this->filename(),
            json_encode($this->data, JSON_PRETTY_PRINT) . PHP_EOL
        );

        return $this;
    }

    private static function sort(array &$array)
    {
        ksort($array);
        foreach ($array as &$arr) {
            if (!is_array($arr)) {
                return;
            };

            static::sort($arr);
        }
    }

    // -------------------------------------------------------------------------
}
