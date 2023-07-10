<?php

namespace App\Domain\ValueObjects;

class NIS
{
    private string $nis;

    public function __construct(string $nis)
    {
        $this->validate($nis);
        $this->nis = $nis;
    }

    public function getValue(): string
    {
        return $this->nis;
    }

    private function validate(string $nis): void
    {
        if (strlen($nis) !== 11) {
            throw new \InvalidArgumentException('NIS must have exactly 11 digits');
        }

        if (!ctype_digit($nis)) {
            throw new \InvalidArgumentException('NIS must contain only numbers');
        }
    }
}
