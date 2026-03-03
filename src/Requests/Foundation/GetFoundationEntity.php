<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Foundation;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetFoundationEntity extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $id,
        protected readonly ?string $releaseId = null,
        protected readonly ?string $include = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/entity/{$this->id}";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'releaseId' => $this->releaseId,
            'include'   => $this->include,
        ], fn ($value) => $value !== null);
    }
}
