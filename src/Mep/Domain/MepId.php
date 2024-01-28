<?php

namespace App\Mep\Domain;

class MepId
{
    public function __construct(
        public readonly int $id
    ) {
    }

    public function value(): int
    {
        return $this->id;
    }

    public function isEquals(MepId $other): bool
    {
        return $this->id === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}