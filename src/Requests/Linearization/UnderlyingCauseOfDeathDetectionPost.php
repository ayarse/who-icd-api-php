<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UnderlyingCauseOfDeathDetectionPost extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $releaseId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/doris";
    }
}
