<?php

namespace App\Mep\Domain;

class MepFullName
{
    public function __construct(
        private readonly string $fullName
    ) {
    }

    public function value(): string
    {
        return $this->fullName;
    }

    public function isEquals(MepFullName $fullName): bool
    {
        return $this->fullName === $fullName->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}