<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class Term
{
    public function __construct(
        public ?LanguageSpecificText $label = null,
        public ?string $foundationReference = null,
        public ?string $linearizationReference = null,
        public ?bool $isInclusion = null,
        public ?bool $isGrouping = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            label: isset($data['label']) && is_array($data['label']) ? LanguageSpecificText::fromArray($data['label']) : null,
            foundationReference: $data['foundationReference'] ?? null,
            linearizationReference: $data['linearizationReference'] ?? null,
            isInclusion: isset($data['isInclusion']) ? (bool) $data['isInclusion'] : null,
            isGrouping: isset($data['isGrouping']) ? (bool) $data['isGrouping'] : null,
        );
    }
}
