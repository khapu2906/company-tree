<?php

namespace Entities;

class Company
{
    public string $id;
    public string $name;
    public string $parentId;
    public array $children = [];    
    public float $cost = 0;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->parentId = $data['parentId'] ?? null;
    }
}