<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class PostcoordinationScaleInfo
{
    public function __construct(
        public ?string $id = null,
        public ?string $axisName = null,
        public ?bool $requiredPostcoordination = null,
        public ?bool $allowMultipleValues = null,
        public array $scaleEntity = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            axisName: $data['axisName'] ?? null,
            requiredPostcoordination: isset($data['requiredPostcoordination']) ? (bool) $data['requiredPostcoordination'] : null,
            allowMultipleValues: isset($data['allowMultipleValues']) ? (bool) $data['allowMultipleValues'] : null,
            scaleEntity: array_map(fn(string $item) => $item, $data['scaleEntity'] ?? []),
        );
    }
}
