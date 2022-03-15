<?php

namespace App\Models;

class Entity
{
    protected int $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function isLoaded(): bool {
        return $this->id != 0;
    }
}