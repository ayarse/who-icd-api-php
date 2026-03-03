<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class GuessWord
{
    public function __construct(
        public ?string $label = null,
        public ?int $dontChangeResult = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            label: $data['label'] ?? null,
            dontChangeResult: isset($data['dontChangeResult']) ? (int) $data['dontChangeResult'] : null,
        );
    }
}
