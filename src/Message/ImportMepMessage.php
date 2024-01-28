<?php

// src/Message/SmsNotification.php

namespace App\Message;

class ImportMepMessage
{
    public function __construct(
        private readonly int $id,
        private readonly string $fullName,
        private readonly string $country,
        private readonly string $politicalGroup,
        private readonly string $nationalPoliticalGroup,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function fullName(): string
    {
        return $this->fullName;
    }

    public function country(): string
    {
        return $this->country;
    }
    public function politicalGroup(): string
    {
        return $this->politicalGroup;
    }
    public function nationalPoliticGroup(): string
    {
        return $this->nationalPoliticalGroup;
    }
}