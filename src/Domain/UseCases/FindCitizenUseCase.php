<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\UseCases\Interfaces\FindCitizenUseCaseInterface;
use App\Domain\Entities\Citizen;

class FindCitizenUseCase implements FindCitizenUseCaseInterface
{
    private CitizenRepositoryInterface $repository;

    public function __construct(CitizenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }  

    public function execute(int $nis): ?Citizen
    {
        $citizen = $this->repository->findByNIS($nis);

        if($citizen) {
            return $citizen;
        }

        return null;
    }
}
