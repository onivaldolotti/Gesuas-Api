<?php

namespace App\Domain\Repositories;

use App\Domain\Models\IlluminateCitizen;
use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\Entities\Citizen;

class IlluminateCitizenRepository implements CitizenRepositoryInterface
{
    public function findByNis(int $nis): ?Citizen
    {
        $citizen = IlluminateCitizen::where('nis', $nis)->first();

        if($citizen) {
            return new Citizen($citizen->name, $citizen->nis);
        }

        return null;
    }

    public function createCitizen(string $name, int $nis): ?Citizen
    {
        $citizen = new IlluminateCitizen();
        $citizen->name = $name;
        $citizen->nis = $nis;
        $citizen->save();

        return new Citizen($citizen->name, $citizen->nis);;
    }
}