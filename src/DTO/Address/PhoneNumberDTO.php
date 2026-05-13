<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Address;

final readonly class PhoneNumberDTO
{
    public function __construct(
        public ?string $number = null,
        public ?string $comment = null,
        public ?string $type = null,
    ) {}

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function isValid(): bool
    {
        return $this->number !== null && $this->number !== '';
    }
}
