<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Foundation;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetFoundation extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $releaseId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/icd/entity';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'releaseId' => $this->releaseId,
        ], fn ($value) => $value !== null);
    }
}
