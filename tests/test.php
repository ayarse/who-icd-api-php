<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$clientId = $_ENV['WHO_ICD_CLIENT_ID'] ?? throw new RuntimeException('Missing WHO_ICD_CLIENT_ID in .env');
$clientSecret = $_ENV['WHO_ICD_CLIENT_SECRET'] ?? throw new RuntimeException('Missing WHO_ICD_CLIENT_SECRET in .env');

echo "=== WHO ICD API PHP SDK Test ===\n\n";

$icd = new WhoIcd\WhoIcdConnector(
    clientId: $clientId,
    clientSecret: $clientSecret,
);

$passed = 0;
$failed = 0;

function test(string $name, callable $fn): void
{
    global $passed, $failed;
    echo "TEST: {$name}\n";
    try {
        $fn();
        $passed++;
        echo "  PASS\n\n";
    } catch (Throwable $e) {
        $failed++;
        echo "  FAIL: {$e->getMessage()}\n";
        echo "  at {$e->getFile()}:{$e->getLine()}\n\n";
    }
}

/** Extract release ID from a URL like http://id.who.int/icd/release/11/2026-01/mms */
function extractReleaseId(string $url): string
{
    $parts = explode('/', $url);
    return $parts[count($parts) - 2];
}

// Pre-fetch the latest MMS release ID (used by most linearization tests)
$releasesResponse = $icd->linearization()->getReleases('mms');
$releases = WhoIcd\Data\MultiVersion::fromArray($releasesResponse->json());
$mmsReleaseId = extractReleaseId($releases->latestRelease);
echo "Using MMS release: {$mmsReleaseId}\n\n";

// ─── Foundation Tests ─────────────────────────────────────────────

test('Foundation > Get top-level entities', function () use ($icd) {
    $response = $icd->foundation()->get();
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\TopLevelFoundation::fromArray($response->json());
    assert($dto->title !== null, 'DTO title should not be null');
    assert(count($dto->child) > 0, 'Should have children');
    echo "  Children: " . count($dto->child) . ", Title: {$dto->title->value}\n";
});

test('Foundation > Get entity by ID', function () use ($icd) {
    $response = $icd->foundation()->getEntity('455013390');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\FoundationEntity::fromArray($response->json());
    assert($dto->title !== null, 'Entity should have a title');
    echo "  Title: {$dto->title->value}\n";
});

test('Foundation > Search for "cholera"', function () use ($icd) {
    $response = $icd->foundation()->search(q: 'cholera');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\ISearchResult::fromArray($response->json());
    assert(count($dto->destinationEntities) > 0, 'Should find results');
    echo "  Results: " . count($dto->destinationEntities) . ", First: {$dto->destinationEntities[0]->title}\n";
});

test('Foundation > AutoCode "diabetes"', function () use ($icd) {
    $response = $icd->foundation()->autoCode(searchText: 'diabetes');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\AutoCodingSearchResult::fromArray($response->json());
    assert($dto->foundationURI !== null, 'Should return a foundation URI');
    echo "  URI: {$dto->foundationURI}, Match: {$dto->matchingText}\n";
});

// ─── Linearization (MMS) Tests ────────────────────────────────────

test('Linearization > Get releases for MMS', function () use ($releases) {
    assert(count($releases->release) > 0, 'Should have at least one release');
    echo "  Releases: " . count($releases->release) . ", Latest: {$releases->latestRelease}\n";
});

test('Linearization > Get MMS linearization', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->get($mmsReleaseId, 'mms');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\TopLevelLinearization::fromArray($response->json());
    assert(count($dto->child) > 0, 'Should have chapters');
    echo "  Chapters: " . count($dto->child) . ", Title: {$dto->title->value}\n";
});

test('Linearization > Get entity (Cholera)', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->getEntity($mmsReleaseId, 'mms', '257068234');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\LinearizationEntity::fromArray($response->json());
    assert($dto->title !== null && $dto->code !== null, 'Should have title and code');
    echo "  Code: {$dto->code}, Title: {$dto->title->value}\n";
});

test('Linearization > Search MMS for "malaria"', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->search($mmsReleaseId, 'mms', q: 'malaria');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\ISearchResult::fromArray($response->json());
    assert(count($dto->destinationEntities) > 0, 'Should find results');
    $first = $dto->destinationEntities[0];
    echo "  Results: " . count($dto->destinationEntities) . ", First: {$first->title} ({$first->theCode})\n";
});

test('Linearization > AutoCode "acute appendicitis"', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->autoCode($mmsReleaseId, 'mms', searchText: 'acute appendicitis');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\AutoCodingSearchResult::fromArray($response->json());
    assert($dto->theCode !== null, 'Should return a code');
    echo "  Code: {$dto->theCode}, Match: {$dto->matchingText}\n";
});

test('Linearization > Lookup foundation entity', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->lookup($mmsReleaseId, 'mms', foundationUri: 'http://id.who.int/icd/entity/257068234');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $data = $response->json();
    echo "  Code: " . ($data['code'] ?? 'N/A') . "\n";
});

test('Linearization > CodeInfo for "1A00"', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->getCodeInfo($mmsReleaseId, 'mms', '1A00');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\CodeInfo::fromArray($response->json());
    echo "  Stem: {$dto->stemCode}, Code: {$dto->code}\n";
});

test('Linearization > Describe code "1A00"', function () use ($icd, $mmsReleaseId) {
    $response = $icd->linearization()->describe($mmsReleaseId, 'mms', code: '1A00');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\PostcoordinationSet::fromArray($response->json());
    echo "  Code: {$dto->theCode}, Title: {$dto->title}\n";
});

// ─── ICD-10 Tests ─────────────────────────────────────────────────

test('ICD-10 > Get releases', function () use ($icd) {
    $response = $icd->icd10()->getReleases();
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $data = $response->json();
    assert(isset($data['release']), 'Should have releases');
    echo "  Releases: " . count($data['release']) . "\n";
});

test('ICD-10 > Get release 2019', function () use ($icd) {
    $response = $icd->icd10()->getRelease('2019');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $data = $response->json();
    assert(isset($data['child']), 'Should have chapters');
    echo "  Chapters: " . count($data['child']) . "\n";
});

test('ICD-10 > Get entity A00 (Cholera)', function () use ($icd) {
    $response = $icd->icd10()->getEntity('2019', 'A00');
    assert($response->status() === 200, "Expected 200, got {$response->status()}");
    $dto = WhoIcd\Data\ICD10Entity::fromArray($response->json());
    assert($dto->title !== null, 'Should have a title');
    echo "  Code: {$dto->code}, Title: {$dto->title->value}\n";
});

// ─── Summary ──────────────────────────────────────────────────────

echo "═══════════════════════════════════════\n";
echo "Results: {$passed} passed, {$failed} failed\n";
echo "═══════════════════════════════════════\n";

exit($failed > 0 ? 1 : 0);
