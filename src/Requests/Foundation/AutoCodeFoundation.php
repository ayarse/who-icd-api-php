<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Foundation;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AutoCodeFoundation extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $searchText,
        protected readonly ?string $releaseId = null,
        protected readonly ?string $subtreesFilter = null,
        protected readonly ?float $matchThreshold = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/icd/entity/autocode';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'searchText'     => $this->searchText,
            'releaseId'      => $this->releaseId,
            'subtreesFilter' => $this->subtreesFilter,
            'matchThreshold' => $this->matchThreshold,
        ], fn ($value) => $value !== null);
    }
}
