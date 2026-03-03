<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class ISimplePropertyValue
{
    public function __construct(
        public ?string $propertyId = null,
        public ?string $label = null,
        public ?float $score = null,
        public ?bool $important = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            propertyId: $data['propertyId'] ?? null,
            label: $data['label'] ?? null,
            score: isset($data['score']) ? (float) $data['score'] : null,
            important: isset($data['important']) ? (bool) $data['important'] : null,
        );
    }
}
