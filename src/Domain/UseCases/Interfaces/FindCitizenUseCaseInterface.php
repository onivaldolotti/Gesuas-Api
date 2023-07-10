<?php

namespace App\Domain\UseCases\Interfaces;

use App\Domain\Entities\Citizen;

interface FindCitizenUseCaseInterface
{
    public function execute(int $nis): ?Citizen;
}