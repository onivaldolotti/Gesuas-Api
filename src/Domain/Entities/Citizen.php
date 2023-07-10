<?php

namespace App\Domain\Entities;

class Citizen
{
    private string $name;
    private string $nis;

    public function __construct(string $name, string $nis)
    {
        $this->name = $name;
        $this->nis = $nis;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNis(): string
    {
        return $this->nis;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'nis' => $this->nis,
        ];
    }
}
