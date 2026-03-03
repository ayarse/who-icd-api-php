<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class DeathCertificateCheckResult
{
    public function __construct(
        public array $report = [],
        public array $errors = [],
        public ?string $underlyingCauseCode = null,
        public ?string $underlyingCauseTitle = null,
        public ?string $underlyingCauseURI = null,
        public ?string $rejectionCode = null,
        public ?string $rejectionReason = null,
        public ?bool $rejected = null,
        public ?string $mannerOfDeath = null,
        public ?string $mainInjury = null,
        public ?int $codingFlags = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            report: $data['report'] ?? [],
            errors: $data['errors'] ?? [],
            underlyingCauseCode: $data['underlyingCauseCode'] ?? null,
            underlyingCauseTitle: $data['underlyingCauseTitle'] ?? null,
            underlyingCauseURI: $data['underlyingCauseURI'] ?? null,
            rejectionCode: $data['rejectionCode'] ?? null,
            rejectionReason: $data['rejectionReason'] ?? null,
            rejected: isset($data['rejected']) ? (bool) $data['rejected'] : null,
            mannerOfDeath: $data['mannerOfDeath'] ?? null,
            mainInjury: $data['mainInjury'] ?? null,
            codingFlags: isset($data['codingFlags']) ? (int) $data['codingFlags'] : null,
        );
    }
}
