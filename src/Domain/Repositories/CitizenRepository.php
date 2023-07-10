<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Citizen;
use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;

class CitizenRepository implements CitizenRepositoryInterface
{
    public function findByNis(int $nis)
    {
        return Citizen::where('nis', $nis)->first();
    }

    public function createCitizen(string $name, int $nis)
    {
        $citizen = new Citizen();
        $citizen->name = $name;
        $citizen->nis = $nis;
        $citizen->save();

        return $citizen;
    }
}