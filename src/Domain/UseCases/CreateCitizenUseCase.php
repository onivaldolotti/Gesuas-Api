<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\UseCases\Interfaces\CreateCitizenUseCaseInterface;
use App\Domain\Models\IlluminateCitizen;
use App\Domain\Entities\Citizen;

class CreateCitizenUseCase implements CreateCitizenUseCaseInterface
{
    private CitizenRepositoryInterface $citizenRepository;

    public function __construct(CitizenRepositoryInterface $citizenRepository)
    {
        $this->citizenRepository = $citizenRepository;
    }

    public function execute(string $name): ?Citizen
    {
        $nis = $this->generateUniqueNis();
       
        return $this->citizenRepository->createCitizen($name, $nis);
    }

    private function generateUniqueNis(): int
    {
        $nis = $this->generateNis();

        $existingCitizen = $this->citizenRepository->findByNis($nis);

        while ($existingCitizen) {
            $nis = $this->generateNis();
            $existingCitizen = $this->citizenRepository->findByNis($nis);
        }

        return $nis;
    }

    private function generateNis(): int
    {      
        $nis = mt_rand(10000000000, 99999999999);

        return $nis;
    }
}
