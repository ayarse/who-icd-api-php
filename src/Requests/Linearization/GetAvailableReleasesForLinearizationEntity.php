<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAvailableReleasesForLinearizationEntity extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $linearizationName,
        protected readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->linearizationName}/{$this->id}";
    }
}
