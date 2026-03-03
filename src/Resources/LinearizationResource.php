<?php

declare(strict_types=1);

namespace WhoIcd\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use WhoIcd\Requests\Linearization\GetReleasesForLinearization;
use WhoIcd\Requests\Linearization\GetAvailableReleasesForLinearizationEntity;
use WhoIcd\Requests\Linearization\GetAvailableReleasesForLinearizationResidualEntity;
use WhoIcd\Requests\Linearization\GetLinearization;
use WhoIcd\Requests\Linearization\GetLinearizationEntity;
use WhoIcd\Requests\Linearization\GetLinearizationResidualEntity;
use WhoIcd\Requests\Linearization\AutoCode;
use WhoIcd\Requests\Linearization\GetCodeInfo;
use WhoIcd\Requests\Linearization\Describe;
use WhoIcd\Requests\Linearization\Lookup;
use WhoIcd\Requests\Linearization\SearchLinearization;
use WhoIcd\Requests\Linearization\SearchLinearizationPost;
use WhoIcd\Requests\Linearization\CertificateCheck;
use WhoIcd\Requests\Linearization\CertificateCheckPost;
use WhoIcd\Requests\Linearization\UnderlyingCauseOfDeathDetection;
use WhoIcd\Requests\Linearization\UnderlyingCauseOfDeathDetectionPost;

class LinearizationResource extends BaseResource
{
    public function getReleases(string $linearizationName): Response
    {
        return $this->connector->send(new GetReleasesForLinearization($linearizationName));
    }

    public function getAvailableReleasesForEntity(string $linearizationName, string $id): Response
    {
        return $this->connector->send(new GetAvailableReleasesForLinearizationEntity($linearizationName, $id));
    }

    public function getAvailableReleasesForResidualEntity(string $linearizationName, string $id, string $residual): Response
    {
        return $this->connector->send(new GetAvailableReleasesForLinearizationResidualEntity($linearizationName, $id, $residual));
    }

    public function get(string $releaseId, string $linearizationName): Response
    {
        return $this->connector->send(new GetLinearization($releaseId, $linearizationName));
    }

    public function getEntity(string $releaseId, string $linearizationName, string $id, ?string $include = null): Response
    {
        return $this->connector->send(new GetLinearizationEntity($releaseId, $linearizationName, $id, $include));
    }

    public function getResidualEntity(string $releaseId, string $linearizationName, string $id, string $residual, ?string $include = null): Response
    {
        return $this->connector->send(new GetLinearizationResidualEntity($releaseId, $linearizationName, $id, $residual, $include));
    }

    public function autoCode(
        string $releaseId,
        string $linearizationName,
        string $searchText,
        ?string $subtreesFilter = null,
        ?float $matchThreshold = null,
    ): Response {
        return $this->connector->send(new AutoCode($releaseId, $linearizationName, $searchText, $subtreesFilter, $matchThreshold));
    }

    public function getCodeInfo(
        string $releaseId,
        string $linearizationName,
        string $code,
        ?bool $flexiblemode = null,
        ?bool $convertToTerminalCodes = null,
    ): Response {
        return $this->connector->send(new GetCodeInfo($releaseId, $linearizationName, $code, $flexiblemode, $convertToTerminalCodes));
    }

    public function describe(
        string $releaseId,
        string $linearizationName,
        ?string $code = null,
        ?string $uri = null,
        ?bool $simplify = null,
        ?bool $flexiblemode = null,
        ?bool $convertToTerminalCodes = null,
    ): Response {
        return $this->connector->send(new Describe($releaseId, $linearizationName, $code, $uri, $simplify, $flexiblemode, $convertToTerminalCodes));
    }

    public function lookup(string $releaseId, string $linearizationName, ?string $foundationUri = null): Response
    {
        return $this->connector->send(new Lookup($releaseId, $linearizationName, $foundationUri));
    }

    public function search(
        string $releaseId,
        string $linearizationName,
        string $q,
        ?string $subtreesFilter = null,
        ?bool $subtreeFilterUsesFoundationDescendants = null,
        ?bool $includeKeywordResult = null,
        ?string $chapterFilter = null,
        ?bool $useFlexisearch = null,
        ?bool $flatResults = null,
        ?bool $highlightingEnabled = null,
        ?bool $medicalCodingMode = null,
        ?string $propertiesToBeSearched = null,
    ): Response {
        return $this->connector->send(new SearchLinearization(
            releaseId: $releaseId,
            linearizationName: $linearizationName,
            q: $q,
            subtreesFilter: $subtreesFilter,
            subtreeFilterUsesFoundationDescendants: $subtreeFilterUsesFoundationDescendants,
            includeKeywordResult: $includeKeywordResult,
            chapterFilter: $chapterFilter,
            useFlexisearch: $useFlexisearch,
            flatResults: $flatResults,
            highlightingEnabled: $highlightingEnabled,
            medicalCodingMode: $medicalCodingMode,
            propertiesToBeSearched: $propertiesToBeSearched,
        ));
    }

    public function searchPost(
        string $releaseId,
        string $linearizationName,
        string $q,
        ?string $subtreesFilter = null,
        ?bool $subtreeFilterUsesFoundationDescendants = null,
        ?bool $includeKeywordResult = null,
        ?string $chapterFilter = null,
        ?bool $useFlexisearch = null,
        ?bool $flatResults = null,
        ?bool $highlightingEnabled = null,
        ?bool $medicalCodingMode = null,
        ?string $propertiesToBeSearched = null,
    ): Response {
        return $this->connector->send(new SearchLinearizationPost(
            releaseId: $releaseId,
            linearizationName: $linearizationName,
            q: $q,
            subtreesFilter: $subtreesFilter,
            subtreeFilterUsesFoundationDescendants: $subtreeFilterUsesFoundationDescendants,
            includeKeywordResult: $includeKeywordResult,
            chapterFilter: $chapterFilter,
            useFlexisearch: $useFlexisearch,
            flatResults: $flatResults,
            highlightingEnabled: $highlightingEnabled,
            medicalCodingMode: $medicalCodingMode,
            propertiesToBeSearched: $propertiesToBeSearched,
        ));
    }

    public function certificateCheck(
        string $releaseId,
        ?int $sex = null,
        ?string $estimatedAge = null,
        ?string $dateBirth = null,
        ?string $dateDeath = null,
        ?string $causeOfDeathCodeA = null,
        ?string $causeOfDeathCodeB = null,
        ?string $causeOfDeathCodeC = null,
        ?string $causeOfDeathCodeD = null,
        ?string $causeOfDeathCodeE = null,
        ?string $causeOfDeathUriA = null,
        ?string $causeOfDeathUriB = null,
        ?string $causeOfDeathUriC = null,
        ?string $causeOfDeathUriD = null,
        ?string $causeOfDeathUriE = null,
        ?string $causeOfDeathCodePart2 = null,
        ?string $causeOfDeathUriPart2 = null,
        ?string $intervalA = null,
        ?string $intervalB = null,
        ?string $intervalC = null,
        ?string $intervalD = null,
        ?string $intervalE = null,
        ?int $surgeryWasPerformed = null,
        ?string $surgeryDate = null,
        ?string $surgeryReason = null,
        ?int $autopsyWasRequested = null,
        ?int $autopsyFindings = null,
        ?int $mannerOfDeath = null,
        ?string $mannerOfDeathDateOfExternalCauseOrPoisoning = null,
        ?string $mannerOfDeathDescriptionExternalCause = null,
        ?int $mannerOfDeathPlaceOfOccuranceExternalCause = null,
        ?int $fetalOrInfantDeathMultiplePregnancy = null,
        ?int $fetalOrInfantDeathStillborn = null,
        ?int $fetalOrInfantDeathDeathWithin24h = null,
        ?int $fetalOrInfantDeathBirthWeight = null,
        ?int $fetalOrInfantDeathPregnancyWeeks = null,
        ?int $fetalOrInfantDeathAgeMother = null,
        ?string $fetalOrInfantDeathPerinatalDescription = null,
        ?int $maternalDeathWasPregnant = null,
        ?int $maternalDeathTimeFromPregnancy = null,
        ?int $maternalDeathPregnancyContribute = null,
    ): Response {
        return $this->connector->send(new CertificateCheck(
            releaseId: $releaseId,
            sex: $sex,
            estimatedAge: $estimatedAge,
            dateBirth: $dateBirth,
            dateDeath: $dateDeath,
            causeOfDeathCodeA: $causeOfDeathCodeA,
            causeOfDeathCodeB: $causeOfDeathCodeB,
            causeOfDeathCodeC: $causeOfDeathCodeC,
            causeOfDeathCodeD: $causeOfDeathCodeD,
            causeOfDeathCodeE: $causeOfDeathCodeE,
            causeOfDeathUriA: $causeOfDeathUriA,
            causeOfDeathUriB: $causeOfDeathUriB,
            causeOfDeathUriC: $causeOfDeathUriC,
            causeOfDeathUriD: $causeOfDeathUriD,
            causeOfDeathUriE: $causeOfDeathUriE,
            causeOfDeathCodePart2: $causeOfDeathCodePart2,
            causeOfDeathUriPart2: $causeOfDeathUriPart2,
            intervalA: $intervalA,
            intervalB: $intervalB,
            intervalC: $intervalC,
            intervalD: $intervalD,
            intervalE: $intervalE,
            surgeryWasPerformed: $surgeryWasPerformed,
            surgeryDate: $surgeryDate,
            surgeryReason: $surgeryReason,
            autopsyWasRequested: $autopsyWasRequested,
            autopsyFindings: $autopsyFindings,
            mannerOfDeath: $mannerOfDeath,
            mannerOfDeathDateOfExternalCauseOrPoisoning: $mannerOfDeathDateOfExternalCauseOrPoisoning,
            mannerOfDeathDescriptionExternalCause: $mannerOfDeathDescriptionExternalCause,
            mannerOfDeathPlaceOfOccuranceExternalCause: $mannerOfDeathPlaceOfOccuranceExternalCause,
            fetalOrInfantDeathMultiplePregnancy: $fetalOrInfantDeathMultiplePregnancy,
            fetalOrInfantDeathStillborn: $fetalOrInfantDeathStillborn,
            fetalOrInfantDeathDeathWithin24h: $fetalOrInfantDeathDeathWithin24h,
            fetalOrInfantDeathBirthWeight: $fetalOrInfantDeathBirthWeight,
            fetalOrInfantDeathPregnancyWeeks: $fetalOrInfantDeathPregnancyWeeks,
            fetalOrInfantDeathAgeMother: $fetalOrInfantDeathAgeMother,
            fetalOrInfantDeathPerinatalDescription: $fetalOrInfantDeathPerinatalDescription,
            maternalDeathWasPregnant: $maternalDeathWasPregnant,
            maternalDeathTimeFromPregnancy: $maternalDeathTimeFromPregnancy,
            maternalDeathPregnancyContribute: $maternalDeathPregnancyContribute,
        ));
    }

    public function certificateCheckPost(string $releaseId): Response
    {
        return $this->connector->send(new CertificateCheckPost($releaseId));
    }

    public function underlyingCauseOfDeathDetection(
        string $releaseId,
        ?int $sex = null,
        ?string $estimatedAge = null,
        ?string $dateBirth = null,
        ?string $dateDeath = null,
        ?string $causeOfDeathCodeA = null,
        ?string $causeOfDeathCodeB = null,
        ?string $causeOfDeathCodeC = null,
        ?string $causeOfDeathCodeD = null,
        ?string $causeOfDeathCodeE = null,
        ?string $causeOfDeathUriA = null,
        ?string $causeOfDeathUriB = null,
        ?string $causeOfDeathUriC = null,
        ?string $causeOfDeathUriD = null,
        ?string $causeOfDeathUriE = null,
        ?string $causeOfDeathCodePart2 = null,
        ?string $causeOfDeathUriPart2 = null,
        ?string $intervalA = null,
        ?string $intervalB = null,
        ?string $intervalC = null,
        ?string $intervalD = null,
        ?string $intervalE = null,
        ?int $surgeryWasPerformed = null,
        ?string $surgeryDate = null,
        ?string $surgeryReason = null,
        ?int $autopsyWasRequested = null,
        ?int $autopsyFindings = null,
        ?int $mannerOfDeath = null,
        ?string $mannerOfDeathDateOfExternalCauseOrPoisoning = null,
        ?string $mannerOfDeathDescriptionExternalCause = null,
        ?int $mannerOfDeathPlaceOfOccuranceExternalCause = null,
        ?int $fetalOrInfantDeathMultiplePregnancy = null,
        ?int $fetalOrInfantDeathStillborn = null,
        ?int $fetalOrInfantDeathDeathWithin24h = null,
        ?int $fetalOrInfantDeathBirthWeight = null,
        ?int $fetalOrInfantDeathPregnancyWeeks = null,
        ?int $fetalOrInfantDeathAgeMother = null,
        ?string $fetalOrInfantDeathPerinatalDescription = null,
        ?int $maternalDeathWasPregnant = null,
        ?int $maternalDeathTimeFromPregnancy = null,
        ?int $maternalDeathPregnancyContribute = null,
    ): Response {
        return $this->connector->send(new UnderlyingCauseOfDeathDetection(
            releaseId: $releaseId,
            sex: $sex,
            estimatedAge: $estimatedAge,
            dateBirth: $dateBirth,
            dateDeath: $dateDeath,
            causeOfDeathCodeA: $causeOfDeathCodeA,
            causeOfDeathCodeB: $causeOfDeathCodeB,
            causeOfDeathCodeC: $causeOfDeathCodeC,
            causeOfDeathCodeD: $causeOfDeathCodeD,
            causeOfDeathCodeE: $causeOfDeathCodeE,
            causeOfDeathUriA: $causeOfDeathUriA,
            causeOfDeathUriB: $causeOfDeathUriB,
            causeOfDeathUriC: $causeOfDeathUriC,
            causeOfDeathUriD: $causeOfDeathUriD,
            causeOfDeathUriE: $causeOfDeathUriE,
            causeOfDeathCodePart2: $causeOfDeathCodePart2,
            causeOfDeathUriPart2: $causeOfDeathUriPart2,
            intervalA: $intervalA,
            intervalB: $intervalB,
            intervalC: $intervalC,
            intervalD: $intervalD,
            intervalE: $intervalE,
            surgeryWasPerformed: $surgeryWasPerformed,
            surgeryDate: $surgeryDate,
            surgeryReason: $surgeryReason,
            autopsyWasRequested: $autopsyWasRequested,
            autopsyFindings: $autopsyFindings,
            mannerOfDeath: $mannerOfDeath,
            mannerOfDeathDateOfExternalCauseOrPoisoning: $mannerOfDeathDateOfExternalCauseOrPoisoning,
            mannerOfDeathDescriptionExternalCause: $mannerOfDeathDescriptionExternalCause,
            mannerOfDeathPlaceOfOccuranceExternalCause: $mannerOfDeathPlaceOfOccuranceExternalCause,
            fetalOrInfantDeathMultiplePregnancy: $fetalOrInfantDeathMultiplePregnancy,
            fetalOrInfantDeathStillborn: $fetalOrInfantDeathStillborn,
            fetalOrInfantDeathDeathWithin24h: $fetalOrInfantDeathDeathWithin24h,
            fetalOrInfantDeathBirthWeight: $fetalOrInfantDeathBirthWeight,
            fetalOrInfantDeathPregnancyWeeks: $fetalOrInfantDeathPregnancyWeeks,
            fetalOrInfantDeathAgeMother: $fetalOrInfantDeathAgeMother,
            fetalOrInfantDeathPerinatalDescription: $fetalOrInfantDeathPerinatalDescription,
            maternalDeathWasPregnant: $maternalDeathWasPregnant,
            maternalDeathTimeFromPregnancy: $maternalDeathTimeFromPregnancy,
            maternalDeathPregnancyContribute: $maternalDeathPregnancyContribute,
        ));
    }

    public function underlyingCauseOfDeathDetectionPost(string $releaseId): Response
    {
        return $this->connector->send(new UnderlyingCauseOfDeathDetectionPost($releaseId));
    }
}
