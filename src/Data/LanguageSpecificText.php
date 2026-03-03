<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class LanguageSpecificText
{
    public function __construct(
        public ?string $language = null,
        public ?string $value = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            language: $data['@language'] ?? $data['language'] ?? null,
            value: $data['@value'] ?? $data['value'] ?? null,
        );
    }
}
