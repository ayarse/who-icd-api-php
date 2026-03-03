<?php

declare(strict_types=1);

namespace WhoIcd\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use WhoIcd\Requests\Icd10\GetICD10Releases;
use WhoIcd\Requests\Icd10\GetAvailableReleasesForICD10Entity;
use WhoIcd\Requests\Icd10\GetICD10Release;
use WhoIcd\Requests\Icd10\GetICD10Entity;

class Icd10Resource extends BaseResource
{
    public function getReleases(): Response
    {
        return $this->connector->send(new GetICD10Releases());
    }

    public function getAvailableReleasesForEntity(string $code): Response
    {
        return $this->connector->send(new GetAvailableReleasesForICD10Entity($code));
    }

    public function getRelease(string $releaseId): Response
    {
        return $this->connector->send(new GetICD10Release($releaseId));
    }

    public function getEntity(string $releaseId, string $code): Response
    {
        return $this->connector->send(new GetICD10Entity($releaseId, $code));
    }
}
