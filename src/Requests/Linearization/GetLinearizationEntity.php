<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetLinearizationEntity extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly string $linearizationName,
        protected readonly string $id,
        protected readonly ?string $include = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/{$this->linearizationName}/{$this->id}";
    }

    public function defaultQuery(): array
    {
        return array_filter(
            ['include' => $this->include],
            fn ($value) => $value !== null,
        );
    }
}
