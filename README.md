# WHO ICD API PHP SDK

A PHP SDK for the [WHO ICD API](https://icd.who.int/icdapi). Provides typed access to ICD-11 Foundation, ICD-11 Linearization (MMS), and ICD-10 endpoints with built-in OAuth2 authentication and Laravel support.

## Requirements

- PHP 8.2+
- A WHO ICD API account ([register here](https://icd.who.int/icdapi))

## Installation

```bash
composer require ayarse/who-icd-api-php
```

## Quick Start

```php
use WhoIcd\WhoIcdConnector;

$icd = new WhoIcdConnector(
    clientId: 'your-client-id',
    clientSecret: 'your-client-secret',
);

// Search for a disease
$response = $icd->linearization()->search('2026-01', 'mms', q: 'diabetes');
$results = $response->json();

// Auto-code free text to an ICD-11 code
$response = $icd->linearization()->autoCode('2026-01', 'mms', searchText: 'acute appendicitis');
$data = $response->json();
echo $data['theCode']; // DB10.0

// Get an entity by ID
$response = $icd->linearization()->getEntity('2026-01', 'mms', '257068234');
$data = $response->json();
echo $data['code']; // 1A00 (Cholera)
```

## Laravel Integration

The package auto-registers via Laravel's package discovery. Add your credentials to `.env`:

```env
WHO_ICD_CLIENT_ID=your-client-id
WHO_ICD_CLIENT_SECRET=your-client-secret
WHO_ICD_LANGUAGE=en
WHO_ICD_API_VERSION=v2
```

Publish the config file:

```bash
php artisan vendor:publish --tag=who-icd-config
```

Then use dependency injection or the facade:

```php
use WhoIcd\WhoIcdConnector;

// Dependency injection
public function search(WhoIcdConnector $icd)
{
    $response = $icd->linearization()->search('2026-01', 'mms', q: 'cholera');
    return $response->json();
}

// Facade
use WhoIcd\Facades\WhoIcd;

$response = WhoIcd::foundation()->search(q: 'cholera');
```

## Configuration

| Env Variable             | Default                                             | Description                                            |
| ------------------------ | --------------------------------------------------- | ------------------------------------------------------ |
| `WHO_ICD_CLIENT_ID`      |                                                     | Your OAuth2 client ID                                  |
| `WHO_ICD_CLIENT_SECRET`  |                                                     | Your OAuth2 client secret                              |
| `WHO_ICD_API_VERSION`    | `v2`                                                | API version header                                     |
| `WHO_ICD_LANGUAGE`       | `en`                                                | Response language (`en`, `es`, `fr`, `zh`, `ar`, etc.) |
| `WHO_ICD_BASE_URL`       | `https://id.who.int`                                | API base URL                                           |
| `WHO_ICD_TOKEN_ENDPOINT` | `https://icdaccessmanagement.who.int/connect/token` | OAuth2 token endpoint                                  |

## API Reference

The SDK is organized into three resource groups accessible from the connector:

### Foundation (`$icd->foundation()`)

The ICD-11 Foundation is the complete ontological layer containing every health entity in a multi-parent graph.

```php
// Get top-level Foundation entities
$icd->foundation()->get();

// Get a specific Foundation entity with optional ancestor/descendant inclusion
$icd->foundation()->getEntity('455013390', include: 'ancestor,descendant');

// Search the Foundation
$icd->foundation()->search(
    q: 'cholera',
    useFlexisearch: true,       // Flexible matching (partial words)
    chapterFilter: '01;02',     // Limit to specific chapters
    highlightingEnabled: false,  // Disable HTML highlight tags
);

// Auto-code free text against the Foundation
$icd->foundation()->autoCode(searchText: 'diabetes mellitus');
```

### Linearization (`$icd->linearization()`)

Linearizations are single-parent, code-bearing classifications derived from the Foundation. The primary linearization is **MMS** (Mortality and Morbidity Statistics).

```php
// List available releases
$icd->linearization()->getReleases('mms');

// Get a specific release (chapters list)
$icd->linearization()->get('2026-01', 'mms');

// Get a coded entity
$icd->linearization()->getEntity('2026-01', 'mms', '257068234');

// Get a residual entity (other/unspecified)
$icd->linearization()->getResidualEntity('2026-01', 'mms', '257068234', 'unspecified');

// Search with full options
$icd->linearization()->search(
    releaseId: '2026-01',
    linearizationName: 'mms',
    q: 'malaria',
    medicalCodingMode: true,         // Only return coded entities
    includeKeywordResult: true,      // Word completion suggestions
    subtreeFilterUsesFoundationDescendants: false,
);

// Auto-code free text to an ICD-11 code
$icd->linearization()->autoCode('2026-01', 'mms', searchText: 'acute appendicitis');

// Look up a code or postcoordinated combination
$icd->linearization()->getCodeInfo('2026-01', 'mms', '1A00');

// Describe a code/URI - can simplify postcoordinated combos
$icd->linearization()->describe('2026-01', 'mms', code: 'GC08&XN6P4', simplify: true);

// Map a Foundation entity to its linearization code
$icd->linearization()->lookup(
    '2026-01', 'mms',
    foundationUri: 'http://id.who.int/icd/entity/257068234',
);

// Death certificate checking (COEDIT)
$icd->linearization()->certificateCheck(
    releaseId: '2026-01',
    sex: 1,
    estimatedAge: 'P65Y',
    causeOfDeathCodeA: 'BA41.Z',
    causeOfDeathCodeB: 'BA80',
);

// Underlying cause of death detection (DORIS)
$icd->linearization()->underlyingCauseOfDeathDetection(
    releaseId: '2026-01',
    sex: 2,
    causeOfDeathCodeA: 'BA41.Z',
);
```

### ICD-10 (`$icd->icd10()`)

Legacy ICD-10 access (browse only, no search).

```php
// List available ICD-10 releases
$icd->icd10()->getReleases();

// Get a specific release (chapters)
$icd->icd10()->getRelease('2019');

// Get an ICD-10 entity
$icd->icd10()->getEntity('2019', 'A00');

// Check which releases contain a specific code
$icd->icd10()->getAvailableReleasesForEntity('A00');
```

## Data Transfer Objects

All API responses can be hydrated into typed DTOs via `::fromArray()`:

```php
use WhoIcd\Data\LinearizationEntity;
use WhoIcd\Data\ISearchResult;
use WhoIcd\Data\AutoCodingSearchResult;

// Entity
$response = $icd->linearization()->getEntity('2026-01', 'mms', '257068234');
$entity = LinearizationEntity::fromArray($response->json());
echo $entity->code;            // "1A00"
echo $entity->title->value;   // "Cholera"

// Search results
$response = $icd->linearization()->search('2026-01', 'mms', q: 'malaria');
$results = ISearchResult::fromArray($response->json());
foreach ($results->destinationEntities as $entity) {
    echo "{$entity->theCode}: {$entity->title}\n";
}

// Auto-coding
$response = $icd->linearization()->autoCode('2026-01', 'mms', searchText: 'heart attack');
$result = AutoCodingSearchResult::fromArray($response->json());
echo $result->theCode;       // "BA41.Z"
echo $result->matchScore;    // 1.0
```

### Available DTOs

| DTO                           | Description                                                     |
| ----------------------------- | --------------------------------------------------------------- |
| `TopLevelFoundation`          | Foundation root with child entities                             |
| `TopLevelLinearization`       | Linearization root with chapters                                |
| `FoundationEntity`            | Full Foundation entity (title, definition, synonyms, hierarchy) |
| `LinearizationEntity`         | Coded entity with postcoordination scales                       |
| `ICD10Entity`                 | ICD-10 category                                                 |
| `ISearchResult`               | Search result container with `destinationEntities`              |
| `ISimpleEntity`               | Individual search result entry                                  |
| `AutoCodingSearchResult`      | Auto-coding match result                                        |
| `CodeInfo`                    | Parsed code / postcoordination breakdown                        |
| `PostcoordinationSet`         | Describe endpoint result                                        |
| `MultiVersion`                | Release listing                                                 |
| `DeathCertificateCheckResult` | COEDIT death certificate check result                           |
| `UnderlyingCauseOfDeath`      | DORIS underlying cause of death result                          |
| `LanguageSpecificText`        | Multilingual text (`language` + `value`)                        |
| `Term`                        | Index term / synonym / inclusion / exclusion                    |

## Language Support

The API supports 20+ languages. Set the language when constructing the connector:

```php
// Spanish
$icd = new WhoIcdConnector($clientId, $clientSecret, language: 'es');

// Chinese
$icd = new WhoIcdConnector($clientId, $clientSecret, language: 'zh');
```

Or in Laravel via `.env`:

```env
WHO_ICD_LANGUAGE=fr
```

## Use Cases

- **Hospital EMR systems** - Code diagnoses at point of care
- **Insurance & billing** - Validate and translate diagnosis codes
- **Mortality statistics** - Automate cause-of-death coding from death certificates
- **Medical research** - Traverse disease hierarchies and relationships
- **Clinical decision support** - Look up definitions, diagnostic criteria, coding notes
- **ICD-10 to ICD-11 migration** - Map legacy codes via Foundation lookup
- **Multilingual health apps** - Serve medical terminology in any supported language

## License

MIT

## Links

- [WHO ICD API Documentation](https://icd.who.int/icdapi)
- [ICD-11 Browser](https://icd.who.int/browse/2026-01/mms/en)
- [Saloon Documentation](https://docs.saloon.dev/)
- [Register for API Access](https://icd.who.int/icdapi)
