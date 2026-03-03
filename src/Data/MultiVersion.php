<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class MultiVersion
{
    public function __construct(
        public ?string $context = null,
        public ?string $id = null,
        public ?LanguageSpecificText $title = null,
        public ?string $latestRelease = null,
        public array $release = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            context: $data['@context'] ?? null,
            id: $data['@id'] ?? null,
            title: isset($data['title']) && is_array($data['title']) ? LanguageSpecificText::fromArray($data['title']) : null,
            latestRelease: $data['latestRelease'] ?? null,
            release: $data['release'] ?? [],
        );
    }
}
