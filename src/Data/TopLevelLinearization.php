<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class TopLevelLinearization
{
    public function __construct(
        public ?string $context = null,
        public ?string $id = null,
        public ?LanguageSpecificText $title = null,
        public array $child = [],
        public ?string $releaseId = null,
        public ?string $browserUrl = null,
        public ?string $language = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            context: $data['@context'] ?? null,
            id: $data['@id'] ?? null,
            title: isset($data['title']) && is_array($data['title']) ? LanguageSpecificText::fromArray($data['title']) : null,
            child: $data['child'] ?? [],
            releaseId: $data['releaseId'] ?? null,
            browserUrl: $data['browserUrl'] ?? null,
            language: $data['language'] ?? null,
        );
    }
}
