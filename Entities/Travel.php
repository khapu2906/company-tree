<?php
namespace Entities;

class Travel
{
    public string $id;
    public string $createdAt;
    public string $employeeName;
    public string $departure;
    public string $destination;
    public float  $price;
    public string $companyId;

    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
        $this->employeeName = $data['employeeName'] ?? null;
        $this->departure = $data['departure'] ?? null;
        $this->destination = $data['destination'] ?? null;
        $this->price = (float)$data['price'] ?? null;
        $this->companyId = $data['companyId'] ?? null;
    }
}