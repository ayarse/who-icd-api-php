<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class PostcoordinationValue
{
    public function __construct(
        public ?string $axis = null,
        public ?string $value = null,
        public ?string $theCode = null,
        public ?string $title = null,
        public ?string $linearizationURI = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            axis: $data['axis'] ?? null,
            value: $data['value'] ?? null,
            theCode: $data['theCode'] ?? null,
            title: $data['title'] ?? null,
            linearizationURI: $data['linearizationURI'] ?? null,
        );
    }
}
