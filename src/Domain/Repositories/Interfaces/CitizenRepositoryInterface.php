<?php

namespace App\Domain\Repositories\Interfaces;

use App\Domain\Entities\Citizen;

interface CitizenRepositoryInterface
{
    public function findByNis(int $nis): ?Citizen;
    
    public function createCitizen(string $name, int $nis): ?Citizen;
}
