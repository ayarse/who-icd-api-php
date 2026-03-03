<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AutoCode extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly string $linearizationName,
        protected readonly string $searchText,
        protected readonly ?string $subtreesFilter = null,
        protected readonly ?float $matchThreshold = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/{$this->linearizationName}/autocode";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'searchText' => $this->searchText,
            'subtreesFilter' => $this->subtreesFilter,
            'matchThreshold' => $this->matchThreshold,
        ], fn ($value) => $value !== null);
    }
}
