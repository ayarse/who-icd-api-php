<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Icd10;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetICD10Entity extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $releaseId,
        protected string $code,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/10/{$this->releaseId}/{$this->code}";
    }
}
