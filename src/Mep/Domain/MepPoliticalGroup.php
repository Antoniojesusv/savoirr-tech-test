<?php

namespace App\Mep\Domain;

class MepPoliticalGroup
{
    public function __construct(
        private readonly string $politicalGroup
    ) {
    }

    public function value(): string
    {
        return $this->politicalGroup;
    }

    public function isEquals(MepPoliticalGroup $politicalGroup): bool
    {
        return $this->politicalGroup === $politicalGroup->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}