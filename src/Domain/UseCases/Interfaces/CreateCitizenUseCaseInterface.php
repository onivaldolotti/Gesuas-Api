<?php

namespace App\Domain\UseCases\Interfaces;

use App\Domain\Entities\Citizen;

interface CreateCitizenUseCaseInterface
{
    public function execute(string $name):? Citizen;
}