<?php

namespace App\Domain\UseCases\Interfaces;

interface FindCitizenUseCaseInterface
{
    public function execute(int $nis);
}