<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAvailableReleasesForLinearizationResidualEntity extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $linearizationName,
        protected readonly string $id,
        protected readonly string $residual,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->linearizationName}/{$this->id}/{$this->residual}";
    }
}
