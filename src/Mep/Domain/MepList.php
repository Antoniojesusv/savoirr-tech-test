<?php

declare(strict_types=1);

namespace App\Mep\Domain;

use App\Mep\Domain\MepCountry;
use App\Mep\Domain\MepFullName;
use App\Mep\Domain\MepNationalPoliticalGroup;
use App\Mep\Domain\MepPoliticalGroup;

final class MepList
{
    public function __construct(
        private MepFullName $fullName,
        private MepCountry $country,
        private MepPoliticalGroup $politicalGroup,
        private MepNationalPoliticalGroup $nationalPoliticalGroup
    ) {
        $this->fullName = $fullName;
        $this->country = $country;
        $this->politicalGroup = $politicalGroup;
        $this->nationalPoliticalGroup = $nationalPoliticalGroup;
    }

    public function fullName(): string
    {
        return $this->fullName->value();
    }

    public function country(): string
    {
        return $this->country->value();
    }

    public function politicalGroup(): string
    {
        return $this->politicalGroup->value();
    }

    public function nationalPoliticalGroup(): string
    {
        return $this->nationalPoliticalGroup->value();
    }

    public function isEquals(Mep $other): bool
    {
        return $this->id() === $other->id();
    }
}
