<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Infrastructure\Persistence;

use Encounter\Encounter\Domain\Encounter;
use Encounter\Encounter\Infrastructure\Persistence\DBALEncounterHydrator;
use Encounter\Encounter\Infrastructure\Persistence\DBALEncounterRepository;
use Test\DBALTestCase;
use Test\Encounter\Encounter\Domain\EncounterMother;

final class DBALEncounterRepositoryTest extends DBALTestCase
{
    private DBALEncounterRepository $encounterRepository;

    public function setUp(): void
    {
        $this->encounterRepository = new DBALEncounterRepository(
            $this->connection(),
            new DBALEncounterHydrator()
        );
        parent::setUp();
    }

    /** @test */
    public function should_save_an_encounter(): void
    {
        $encounter = EncounterMother::random();

        $this->encounterRepository->save($encounter);
    }

    /** @test */
    public function should_get_an_encounter(): void
    {
        $encounter = EncounterMother::random();

        $this->encounterRepository->save($encounter);

        $storedEncounter = $this->encounterRepository->findById($encounter->encounterId());

        $this->assertInstanceOf(Encounter::class, $storedEncounter);
        $this->assertEquals($encounter, $storedEncounter);
    }
}
