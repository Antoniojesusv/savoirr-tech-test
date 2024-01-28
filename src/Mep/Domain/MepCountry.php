<?php

namespace App\Mep\Domain;

class MepCountry
{
    public function __construct(
        private readonly string $country
    ) {
    }

    public function value(): string
    {
        return $this->country;
    }

    public function isEquals(MepCountry $country): bool
    {
        return $this->country === $country->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}