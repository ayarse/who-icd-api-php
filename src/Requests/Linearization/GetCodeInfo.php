<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCodeInfo extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly string $linearizationName,
        protected readonly string $code,
        protected readonly ?bool $flexiblemode = null,
        protected readonly ?bool $convertToTerminalCodes = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/{$this->linearizationName}/codeinfo/{$this->code}";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'flexiblemode' => $this->flexiblemode,
            'convertToTerminalCodes' => $this->convertToTerminalCodes,
        ], fn ($value) => $value !== null);
    }
}
