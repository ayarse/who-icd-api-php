<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class ISimpleEntity
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?string $stemId = null,
        public ?string $theCode = null,
        public ?string $chapter = null,
        public ?float $score = null,
        public ?bool $titleIsASearchResult = null,
        public ?bool $titleIsTopScore = null,
        public ?int $entityType = null,
        public ?int $important = null,
        public ?bool $hasCodingNote = null,
        public ?bool $hasMaternalChapterLink = null,
        public ?int $postcoordinationAvailability = null,
        public ?bool $isResidualOther = null,
        public ?bool $isResidualUnspecified = null,
        public ?bool $isLeaf = null,
        public array $matchingPVs = [],
        public ?bool $propertiesTruncated = null,
        public ?bool $isInMMS = null,
        public array $descendants = [],
        public ?string $urlId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'] ?? null,
            stemId: $data['stemId'] ?? null,
            theCode: $data['theCode'] ?? null,
            chapter: $data['chapter'] ?? null,
            score: isset($data['score']) ? (float) $data['score'] : null,
            titleIsASearchResult: isset($data['titleIsASearchResult']) ? (bool) $data['titleIsASearchResult'] : null,
            titleIsTopScore: isset($data['titleIsTopScore']) ? (bool) $data['titleIsTopScore'] : null,
            entityType: isset($data['entityType']) ? (int) $data['entityType'] : null,
            important: isset($data['important']) ? (int) $data['important'] : null,
            hasCodingNote: isset($data['hasCodingNote']) ? (bool) $data['hasCodingNote'] : null,
            hasMaternalChapterLink: isset($data['hasMaternalChapterLink']) ? (bool) $data['hasMaternalChapterLink'] : null,
            postcoordinationAvailability: isset($data['postcoordinationAvailability']) ? (int) $data['postcoordinationAvailability'] : null,
            isResidualOther: isset($data['isResidualOther']) ? (bool) $data['isResidualOther'] : null,
            isResidualUnspecified: isset($data['isResidualUnspecified']) ? (bool) $data['isResidualUnspecified'] : null,
            isLeaf: isset($data['isLeaf']) ? (bool) $data['isLeaf'] : null,
            matchingPVs: array_map(
                fn(array $item) => ISimplePropertyValue::fromArray($item),
                $data['matchingPVs'] ?? [],
            ),
            propertiesTruncated: isset($data['propertiesTruncated']) ? (bool) $data['propertiesTruncated'] : null,
            isInMMS: isset($data['isInMMS']) ? (bool) $data['isInMMS'] : null,
            descendants: array_map(
                fn(array $item) => ISimpleEntity::fromArray($item),
                $data['descendants'] ?? [],
            ),
            urlId: $data['urlId'] ?? null,
        );
    }
}
