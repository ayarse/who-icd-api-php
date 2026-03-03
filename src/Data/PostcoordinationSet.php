<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class PostcoordinationSet
{
    public function __construct(
        public ?string $context = null,
        public ?string $id = null,
        public ?string $stemId = null,
        public ?string $theCode = null,
        public ?string $title = null,
        public ?string $stemCode = null,
        public ?string $linearizationURI = null,
        public array $postcoordinations = [],
        public array $otherPostcoordination = [],
        public ?bool $hasError = null,
        public ?string $errorMessage = null,
        public ?string $stemCode2 = null,
        public ?string $postcoordinationCode = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            context: $data['@context'] ?? null,
            id: $data['@id'] ?? null,
            stemId: $data['stemId'] ?? null,
            theCode: $data['theCode'] ?? null,
            title: $data['title'] ?? null,
            stemCode: $data['stemCode'] ?? null,
            linearizationURI: $data['linearizationURI'] ?? null,
            postcoordinations: array_map(fn(array $item) => PostcoordinationValue::fromArray($item), $data['postcoordinations'] ?? []),
            otherPostcoordination: array_map(fn(array $item) => PostcoordinationValue::fromArray($item), $data['otherPostcoordination'] ?? []),
            hasError: isset($data['hasError']) ? (bool) $data['hasError'] : null,
            errorMessage: $data['errorMessage'] ?? null,
            stemCode2: $data['stemCode2'] ?? null,
            postcoordinationCode: $data['postcoordinationCode'] ?? null,
        );
    }
}
