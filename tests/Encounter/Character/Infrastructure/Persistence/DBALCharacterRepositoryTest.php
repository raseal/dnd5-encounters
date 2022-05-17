<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Infrastructure\Persistence;

use Encounter\Character\Domain\Character;
use Encounter\Character\Infrastructure\Persistence\DBALCharacterHydrator;
use Encounter\Character\Infrastructure\Persistence\DBALCharacterRepository;
use Test\DBALTestCase;
use Test\Encounter\Character\Domain\CharacterMother;

final class DBALCharacterRepositoryTest extends DBALTestCase
{
    private DBALCharacterRepository $characterRepository;

    public function setUp(): void
    {
        $this->characterRepository = new DBALCharacterRepository(
            $this->connection(),
            new DBALCharacterHydrator()
        );
        parent::setUp();
    }

    /** @test */
    public function should_save_a_character(): void
    {
        $character = CharacterMother::random();

        $this->characterRepository->save($character);
    }

    /** @test */
    public function should_get_a_character(): void
    {
        $character = CharacterMother::random();

        $this->characterRepository->save($character);

        $storedCharacter = $this->characterRepository->findById($character->characterId());

        $this->assertInstanceOf(Character::class, $storedCharacter);
        $this->assertEquals($character, $storedCharacter);
    }
}
