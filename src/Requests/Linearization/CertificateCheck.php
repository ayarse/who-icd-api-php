<?php

declare(strict_types=1);

namespace WhoIcd\Requests\Linearization;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CertificateCheck extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $releaseId,
        protected readonly ?int $sex = null,
        protected readonly ?string $estimatedAge = null,
        protected readonly ?string $dateBirth = null,
        protected readonly ?string $dateDeath = null,
        protected readonly ?string $causeOfDeathCodeA = null,
        protected readonly ?string $causeOfDeathCodeB = null,
        protected readonly ?string $causeOfDeathCodeC = null,
        protected readonly ?string $causeOfDeathCodeD = null,
        protected readonly ?string $causeOfDeathCodeE = null,
        protected readonly ?string $causeOfDeathUriA = null,
        protected readonly ?string $causeOfDeathUriB = null,
        protected readonly ?string $causeOfDeathUriC = null,
        protected readonly ?string $causeOfDeathUriD = null,
        protected readonly ?string $causeOfDeathUriE = null,
        protected readonly ?string $causeOfDeathCodePart2 = null,
        protected readonly ?string $causeOfDeathUriPart2 = null,
        protected readonly ?string $intervalA = null,
        protected readonly ?string $intervalB = null,
        protected readonly ?string $intervalC = null,
        protected readonly ?string $intervalD = null,
        protected readonly ?string $intervalE = null,
        protected readonly ?int $surgeryWasPerformed = null,
        protected readonly ?string $surgeryDate = null,
        protected readonly ?string $surgeryReason = null,
        protected readonly ?int $autopsyWasRequested = null,
        protected readonly ?int $autopsyFindings = null,
        protected readonly ?int $mannerOfDeath = null,
        protected readonly ?string $mannerOfDeathDateOfExternalCauseOrPoisoning = null,
        protected readonly ?string $mannerOfDeathDescriptionExternalCause = null,
        protected readonly ?int $mannerOfDeathPlaceOfOccuranceExternalCause = null,
        protected readonly ?int $fetalOrInfantDeathMultiplePregnancy = null,
        protected readonly ?int $fetalOrInfantDeathStillborn = null,
        protected readonly ?int $fetalOrInfantDeathDeathWithin24h = null,
        protected readonly ?int $fetalOrInfantDeathBirthWeight = null,
        protected readonly ?int $fetalOrInfantDeathPregnancyWeeks = null,
        protected readonly ?int $fetalOrInfantDeathAgeMother = null,
        protected readonly ?string $fetalOrInfantDeathPerinatalDescription = null,
        protected readonly ?int $maternalDeathWasPregnant = null,
        protected readonly ?int $maternalDeathTimeFromPregnancy = null,
        protected readonly ?int $maternalDeathPregnancyContribute = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/icd/release/11/{$this->releaseId}/codedit";
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'sex' => $this->sex,
            'estimatedAge' => $this->estimatedAge,
            'dateBirth' => $this->dateBirth,
            'dateDeath' => $this->dateDeath,
            'causeOfDeathCodeA' => $this->causeOfDeathCodeA,
            'causeOfDeathCodeB' => $this->causeOfDeathCodeB,
            'causeOfDeathCodeC' => $this->causeOfDeathCodeC,
            'causeOfDeathCodeD' => $this->causeOfDeathCodeD,
            'causeOfDeathCodeE' => $this->causeOfDeathCodeE,
            'causeOfDeathUriA' => $this->causeOfDeathUriA,
            'causeOfDeathUriB' => $this->causeOfDeathUriB,
            'causeOfDeathUriC' => $this->causeOfDeathUriC,
            'causeOfDeathUriD' => $this->causeOfDeathUriD,
            'causeOfDeathUriE' => $this->causeOfDeathUriE,
            'causeOfDeathCodePart2' => $this->causeOfDeathCodePart2,
            'causeOfDeathUriPart2' => $this->causeOfDeathUriPart2,
            'intervalA' => $this->intervalA,
            'intervalB' => $this->intervalB,
            'intervalC' => $this->intervalC,
            'intervalD' => $this->intervalD,
            'intervalE' => $this->intervalE,
            'surgeryWasPerformed' => $this->surgeryWasPerformed,
            'surgeryDate' => $this->surgeryDate,
            'surgeryReason' => $this->surgeryReason,
            'autopsyWasRequested' => $this->autopsyWasRequested,
            'autopsyFindings' => $this->autopsyFindings,
            'mannerOfDeath' => $this->mannerOfDeath,
            'mannerOfDeathDateOfExternalCauseOrPoisoning' => $this->mannerOfDeathDateOfExternalCauseOrPoisoning,
            'mannerOfDeathDescriptionExternalCause' => $this->mannerOfDeathDescriptionExternalCause,
            'mannerOfDeathPlaceOfOccuranceExternalCause' => $this->mannerOfDeathPlaceOfOccuranceExternalCause,
            'fetalOrInfantDeathMultiplePregnancy' => $this->fetalOrInfantDeathMultiplePregnancy,
            'fetalOrInfantDeathStillborn' => $this->fetalOrInfantDeathStillborn,
            'fetalOrInfantDeathDeathWithin24h' => $this->fetalOrInfantDeathDeathWithin24h,
            'fetalOrInfantDeathBirthWeight' => $this->fetalOrInfantDeathBirthWeight,
            'fetalOrInfantDeathPregnancyWeeks' => $this->fetalOrInfantDeathPregnancyWeeks,
            'fetalOrInfantDeathAgeMother' => $this->fetalOrInfantDeathAgeMother,
            'fetalOrInfantDeathPerinatalDescription' => $this->fetalOrInfantDeathPerinatalDescription,
            'maternalDeathWasPregnant' => $this->maternalDeathWasPregnant,
            'maternalDeathTimeFromPregnancy' => $this->maternalDeathTimeFromPregnancy,
            'maternalDeathPregnancyContribute' => $this->maternalDeathPregnancyContribute,
        ], fn ($value) => $value !== null);
    }
}
