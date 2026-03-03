<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Icd10;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetICD10Releases extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/icd/release/10';
    }
}
