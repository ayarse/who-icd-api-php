<?php

declare(strict_types=1);

namespace WhoIcd\Data;

final readonly class ISearchResult
{
    public function __construct(
        public ?string $context = null,
        public ?string $id = null,
        public ?bool $error = null,
        public ?string $errorMessage = null,
        public ?bool $resultChopped = null,
        public ?bool $wordSuggestionsChopped = null,
        public ?int $guessType = null,
        public ?string $uniqueSearchId = null,
        public array $words = [],
        public array $destinationEntities = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            context: $data['@context'] ?? null,
            id: $data['@id'] ?? null,
            error: isset($data['error']) ? (bool) $data['error'] : null,
            errorMessage: $data['errorMessage'] ?? null,
            resultChopped: isset($data['resultChopped']) ? (bool) $data['resultChopped'] : null,
            wordSuggestionsChopped: isset($data['wordSuggestionsChopped']) ? (bool) $data['wordSuggestionsChopped'] : null,
            guessType: isset($data['guessType']) ? (int) $data['guessType'] : null,
            uniqueSearchId: isset($data['uniqueSearchId']) ? (string) $data['uniqueSearchId'] : null,
            words: is_array($data['words'] ?? null)
                ? array_map(fn(array $item) => GuessWord::fromArray($item), $data['words'])
                : [],
            destinationEntities: is_array($data['destinationEntities'] ?? null)
                ? array_map(fn(array $item) => ISimpleEntity::fromArray($item), $data['destinationEntities'])
                : [],
        );
    }
}
