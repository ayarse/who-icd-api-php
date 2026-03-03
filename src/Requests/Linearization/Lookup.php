<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class Lookup extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly string $linearizationName,
        protected readonly ?string $foundationUri = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/{$this->linearizationName}/lookup";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'foundationUri' => $this->foundationUri,
        ], fn ($value) => $value !== null);
    }
}
