<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetLinearization extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly string $linearizationName,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/{$this->linearizationName}";
    }
}
