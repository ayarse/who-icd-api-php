<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchLinearization extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly string $linearizationName,
        protected readonly string $q,
        protected readonly ?string $subtreesFilter = null,
        protected readonly ?bool $subtreeFilterUsesFoundationDescendants = null,
        protected readonly ?bool $includeKeywordResult = null,
        protected readonly ?string $chapterFilter = null,
        protected readonly ?bool $useFlexisearch = null,
        protected readonly ?bool $flatResults = null,
        protected readonly ?bool $highlightingEnabled = null,
        protected readonly ?bool $medicalCodingMode = null,
        protected readonly ?string $propertiesToBeSearched = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/{$this->linearizationName}/search";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'q' => $this->q,
            'subtreesFilter' => $this->subtreesFilter,
            'subtreeFilterUsesFoundationDescendants' => $this->subtreeFilterUsesFoundationDescendants,
            'includeKeywordResult' => $this->includeKeywordResult,
            'chapterFilter' => $this->chapterFilter,
            'useFlexisearch' => $this->useFlexisearch,
            'flatResults' => $this->flatResults,
            'highlightingEnabled' => $this->highlightingEnabled,
            'medicalCodingMode' => $this->medicalCodingMode,
            'propertiesToBeSearched' => $this->propertiesToBeSearched,
        ], fn ($value) => $value !== null);
    }
}
