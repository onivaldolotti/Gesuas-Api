<?php

namespace App\Domain\UseCases;

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\UseCases\Interfaces\FindCitizenUseCaseInterface;

class FindCitizenUseCase implements FindCitizenUseCaseInterface
{
    private CitizenRepositoryInterface $repository;

    public function __construct(CitizenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }  

    public function execute(int $nis)
    {
        $citizen = $this->repository->findByNIS($nis);

        if ($citizen) {
            return [
                'name' => $citizen->name,
                'nis' => $citizen->nis,
            ];
        }

        return ['message' => 'Cidadão não encontrado'];
    }
}
