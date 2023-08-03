<?php

use Pebble\Models\ModelAbstract;

class User extends ModelAbstract
{
    public ?int $id;
    public ?string $name;
    public int $created_at;

    public function init(): static
    {
        $this->id = null;
        $this->name = null;
        $this->created_at = time();

        return $this;
    }
}
