<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class AutoCodingSearchResult
{
    public function __construct(
        public ?string $searchText = null,
        public ?string $matchingText = null,
        public ?string $theCode = null,
        public ?string $foundationURI = null,
        public ?string $linearizationURI = null,
        public ?int $matchLevel = null,
        public ?float $matchScore = null,
        public ?int $matchType = null,
        public ?bool $isTitle = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            searchText: $data['searchText'] ?? null,
            matchingText: $data['matchingText'] ?? null,
            theCode: $data['theCode'] ?? null,
            foundationURI: $data['foundationURI'] ?? null,
            linearizationURI: $data['linearizationURI'] ?? null,
            matchLevel: isset($data['matchLevel']) ? (int) $data['matchLevel'] : null,
            matchScore: isset($data['matchScore']) ? (float) $data['matchScore'] : null,
            matchType: isset($data['matchType']) ? (int) $data['matchType'] : null,
            isTitle: isset($data['isTitle']) ? (bool) $data['isTitle'] : null,
        );
    }
}
