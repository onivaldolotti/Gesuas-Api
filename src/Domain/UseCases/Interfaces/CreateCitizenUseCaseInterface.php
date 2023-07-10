<?php

namespace App\Domain\UseCases\Interfaces;

interface CreateCitizenUseCaseInterface
{
    public function execute(string $name);
}