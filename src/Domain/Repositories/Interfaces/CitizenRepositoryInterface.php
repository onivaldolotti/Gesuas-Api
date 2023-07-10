<?php

namespace App\Domain\Repositories\Interfaces;

use App\Domain\Models\Citizen;

interface CitizenRepositoryInterface
{
    public function findByNis(int $nis);
    
    public function createCitizen(string $name, int $nis);
}
