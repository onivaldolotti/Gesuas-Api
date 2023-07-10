<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\UseCases\Interfaces\CreateCitizenUseCaseInterface;

class CreateCitizenUseCase implements CreateCitizenUseCaseInterface
{
    private CitizenRepositoryInterface $citizenRepository;

    public function __construct(CitizenRepositoryInterface $citizenRepository)
    {
        $this->citizenRepository = $citizenRepository;
    }

    public function execute(string $name)
    {
        $nis = $this->generateUniqueNis();
       
        $citizen = $this->citizenRepository->createCitizen($name, $nis);

        return $citizen;
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
