<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class ICD10Entity
{
    public function __construct(
        public ?string $context = null,
        public ?string $id = null,
        public ?LanguageSpecificText $title = null,
        public ?string $code = null,
        public array $child = [],
        public array $parent = [],
        public ?string $browserUrl = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            context: $data['@context'] ?? null,
            id: $data['@id'] ?? null,
            title: isset($data['title']) && is_array($data['title']) ? LanguageSpecificText::fromArray($data['title']) : null,
            code: $data['code'] ?? null,
            child: $data['child'] ?? [],
            parent: $data['parent'] ?? [],
            browserUrl: $data['browserUrl'] ?? null,
        );
    }
}
