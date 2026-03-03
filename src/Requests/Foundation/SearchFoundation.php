<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Foundation;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchFoundation extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $q,
        protected readonly ?string $subtreesFilter = null,
        protected readonly ?string $chapterFilter = null,
        protected readonly ?bool $useFlexisearch = null,
        protected readonly ?bool $flatResults = null,
        protected readonly ?string $propertiesToBeSearched = null,
        protected readonly ?string $releaseId = null,
        protected readonly ?bool $highlightingEnabled = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/icd/entity/search';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'q'                      => $this->q,
            'subtreesFilter'         => $this->subtreesFilter,
            'chapterFilter'          => $this->chapterFilter,
            'useFlexisearch'         => $this->useFlexisearch,
            'flatResults'            => $this->flatResults,
            'propertiesToBeSearched' => $this->propertiesToBeSearched,
            'releaseId'              => $this->releaseId,
            'highlightingEnabled'    => $this->highlightingEnabled,
        ], fn ($value) => $value !== null);
    }
}
