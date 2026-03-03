<?php

declare(strict_types=1);

namespace WhoIcd\Facades;

use Illuminate\Support\Facades\Facade;
use WhoIcd\WhoIcdConnector;

/**
 * @method static \WhoIcd\Resources\FoundationResource foundation()
 * @method static \WhoIcd\Resources\LinearizationResource linearization()
 * @method static \WhoIcd\Resources\Icd10Resource icd10()
 * @method static \Saloon\Http\Response send(\Saloon\Http\Request $request)
 *
 * @see \WhoIcd\WhoIcdConnector
 */
class WhoIcd extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WhoIcdConnector::class;
    }
}
