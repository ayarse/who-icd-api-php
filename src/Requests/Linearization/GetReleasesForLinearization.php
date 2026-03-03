<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetReleasesForLinearization extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $linearizationName,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->linearizationName}";
    }
}
