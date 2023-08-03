<?php

namespace Pebble\Models;

use ReflectionClass;

/**
 * Get & Store class informations
 */
final class Reflection
{
    private static array $cache = [];

    private string $classname;
    private ?array $properties = null;
    private ?array $methods = null;

    /**
     * @param string $classname
     */
    protected function __construct(string $classname)
    {
        $this->classname = $classname;
    }

    /**
     * @param string $classname
     * @return static
     */
    public static function getInstance(string $classname): static
    {
        if (!isset(self::$cache[$classname])) {
            self::$cache[$classname] = new static($classname);
        }

        return self::$cache[$classname];
    }

    /**
     * @return array
     */
    public function properties(): array
    {
        if ($this->properties === null) {
            $this->properties = [];
            foreach ($this->reflectionClass()->getProperties() as $item) {
                if ($item->isPublic() && !$item->isStatic()) {
                    $this->properties[] = $item->getName();
                }
            }
        }

        return $this->properties;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function hasProperty(string $key): bool
    {
        return in_array($key, $this->properties());
    }

    /**
     * @return array
     */
    public function methods(): array
    {
        if ($this->methods === null) {
            $this->methods = [];
            foreach ($this->reflectionClass()->getMethods() as $item) {
                if ($item->isPublic() && !$item->isStatic()) {
                    $this->methods[] = $item->getName();
                }
            }
        }

        return $this->methods;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function hasMethod(string $key): bool
    {
        return in_array($key, $this->methods());
    }

    /**
     * @return ReflectionClass
     */
    private function reflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->classname);
    }
}
