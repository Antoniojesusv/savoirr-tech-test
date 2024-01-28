<?php

namespace App\Mep\Domain;

class MepNationalPoliticalGroup
{
    public function __construct(
        private readonly string $nationalPoliticalGroup
    ) {
    }

    public function value(): string
    {
        return $this->nationalPoliticalGroup;
    }

    public function isEquals(MepNationalPoliticalGroup $nationalPoliticalGroup): bool
    {
        return $this->nationalPoliticalGroup === $nationalPoliticalGroup->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}