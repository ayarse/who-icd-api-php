<?php

declare(strict_types=1);

namespace WhoIcd\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use WhoIcd\Requests\Foundation\GetFoundation;
use WhoIcd\Requests\Foundation\GetFoundationEntity;
use WhoIcd\Requests\Foundation\AutoCodeFoundation;
use WhoIcd\Requests\Foundation\SearchFoundation;
use WhoIcd\Requests\Foundation\SearchFoundationPost;

class FoundationResource extends BaseResource
{
    public function get(?string $releaseId = null): Response
    {
        return $this->connector->send(new GetFoundation($releaseId));
    }

    public function getEntity(string $id, ?string $releaseId = null, ?string $include = null): Response
    {
        return $this->connector->send(new GetFoundationEntity($id, $releaseId, $include));
    }

    public function autoCode(
        string $searchText,
        ?string $releaseId = null,
        ?string $subtreesFilter = null,
        ?float $matchThreshold = null,
    ): Response {
        return $this->connector->send(new AutoCodeFoundation($searchText, $releaseId, $subtreesFilter, $matchThreshold));
    }

    public function search(
        string $q,
        ?string $subtreesFilter = null,
        ?string $chapterFilter = null,
        ?bool $useFlexisearch = null,
        ?bool $flatResults = null,
        ?string $propertiesToBeSearched = null,
        ?string $releaseId = null,
        ?bool $highlightingEnabled = null,
    ): Response {
        return $this->connector->send(new SearchFoundation(
            q: $q,
            subtreesFilter: $subtreesFilter,
            chapterFilter: $chapterFilter,
            useFlexisearch: $useFlexisearch,
            flatResults: $flatResults,
            propertiesToBeSearched: $propertiesToBeSearched,
            releaseId: $releaseId,
            highlightingEnabled: $highlightingEnabled,
        ));
    }

    public function searchPost(
        string $q,
        ?string $subtreesFilter = null,
        ?string $chapterFilter = null,
        ?bool $useFlexisearch = null,
        ?bool $flatResults = null,
        ?string $propertiesToBeSearched = null,
        ?string $releaseId = null,
        ?bool $highlightingEnabled = null,
    ): Response {
        return $this->connector->send(new SearchFoundationPost(
            q: $q,
            subtreesFilter: $subtreesFilter,
            chapterFilter: $chapterFilter,
            useFlexisearch: $useFlexisearch,
            flatResults: $flatResults,
            propertiesToBeSearched: $propertiesToBeSearched,
            releaseId: $releaseId,
            highlightingEnabled: $highlightingEnabled,
        ));
    }
}
