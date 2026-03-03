<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class LinearizationEntity
{
    public function __construct(
        public ?string $context = null,
        public ?string $id = null,
        public ?LanguageSpecificText $title = null,
        public ?LanguageSpecificText $definition = null,
        public ?LanguageSpecificText $longDefinition = null,
        public ?LanguageSpecificText $fullySpecifiedName = null,
        public ?LanguageSpecificText $diagnosticCriteria = null,
        public ?LanguageSpecificText $codingNote = null,
        public ?string $blockId = null,
        public ?string $codeRange = null,
        public ?string $classKind = null,
        public ?string $source = null,
        public ?string $code = null,
        public array $foundationChildElsewhere = [],
        public array $indexTerm = [],
        public array $child = [],
        public array $parent = [],
        public array $ancestor = [],
        public array $descendant = [],
        public array $synonym = [],
        public array $narrowerTerm = [],
        public array $inclusion = [],
        public array $exclusion = [],
        public ?string $browserUrl = null,
        public array $postcoordinationScale = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            context: $data['@context'] ?? null,
            id: $data['@id'] ?? null,
            title: isset($data['title']) ? LanguageSpecificText::fromArray($data['title']) : null,
            definition: isset($data['definition']) ? LanguageSpecificText::fromArray($data['definition']) : null,
            longDefinition: isset($data['longDefinition']) ? LanguageSpecificText::fromArray($data['longDefinition']) : null,
            fullySpecifiedName: isset($data['fullySpecifiedName']) ? LanguageSpecificText::fromArray($data['fullySpecifiedName']) : null,
            diagnosticCriteria: isset($data['diagnosticCriteria']) ? LanguageSpecificText::fromArray($data['diagnosticCriteria']) : null,
            codingNote: isset($data['codingNote']) ? LanguageSpecificText::fromArray($data['codingNote']) : null,
            blockId: $data['blockId'] ?? null,
            codeRange: $data['codeRange'] ?? null,
            classKind: $data['classKind'] ?? null,
            source: $data['source'] ?? null,
            code: $data['code'] ?? null,
            foundationChildElsewhere: array_map(fn(array $item) => Term::fromArray($item), $data['foundationChildElsewhere'] ?? []),
            indexTerm: array_map(fn(array $item) => Term::fromArray($item), $data['indexTerm'] ?? []),
            child: $data['child'] ?? [],
            parent: $data['parent'] ?? [],
            ancestor: $data['ancestor'] ?? [],
            descendant: $data['descendant'] ?? [],
            synonym: array_map(fn(array $item) => Term::fromArray($item), $data['synonym'] ?? []),
            narrowerTerm: array_map(fn(array $item) => Term::fromArray($item), $data['narrowerTerm'] ?? []),
            inclusion: array_map(fn(array $item) => Term::fromArray($item), $data['inclusion'] ?? []),
            exclusion: array_map(fn(array $item) => Term::fromArray($item), $data['exclusion'] ?? []),
            browserUrl: $data['browserUrl'] ?? null,
            postcoordinationScale: array_map(fn(array $item) => PostcoordinationScaleInfo::fromArray($item), $data['postcoordinationScale'] ?? []),
        );
    }
}
