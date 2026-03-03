<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class CodeInfo
{
    public function __construct(
        public ?string $code = null,
        public ?string $stemCode = null,
        public ?string $stemId = null,
        public ?string $simplifiedCode = null,
        public ?string $linearizationURI = null,
        public ?string $foundationURI = null,
        public ?string $title = null,
        public array $postcoordinations = [],
        public array $otherPostcoordination = [],
        public ?bool $hasError = null,
        public ?string $errorMessage = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            stemCode: $data['stemCode'] ?? null,
            stemId: $data['stemId'] ?? null,
            simplifiedCode: $data['simplifiedCode'] ?? null,
            linearizationURI: $data['linearizationURI'] ?? null,
            foundationURI: $data['foundationURI'] ?? null,
            title: $data['title'] ?? null,
            postcoordinations: array_map(fn(array $item) => PostcoordinationValue::fromArray($item), $data['postcoordinations'] ?? []),
            otherPostcoordination: array_map(fn(array $item) => PostcoordinationValue::fromArray($item), $data['otherPostcoordination'] ?? []),
            hasError: isset($data['hasError']) ? (bool) $data['hasError'] : null,
            errorMessage: $data['errorMessage'] ?? null,
        );
    }
}
