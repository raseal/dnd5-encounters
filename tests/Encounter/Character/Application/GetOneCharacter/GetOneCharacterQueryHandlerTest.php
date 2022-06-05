<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Application\GetOneCharacter;

use Encounter\Character\Application\GetOneCharacter\GetOneCharacter;
use Encounter\Character\Application\GetOneCharacter\GetOneCharacterQueryHandler;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;
use PHPUnit\Framework\TestCase;
use Test\Encounter\Character\Domain\CharacterMother;

final class GetOneCharacterQueryHandlerTest extends TestCase
{
    private CharacterRepository $characterRepository;
    private GetOneCharacterQueryHandler $getOneCharacterQueryHandler;

    public function setUp(): void
    {
        $this->characterRepository = $this->createMock(CharacterRepository::class);
        $this->getOneCharacterQueryHandler = new GetOneCharacterQueryHandler(
            new GetOneCharacter(
                $this->characterRepository
            )
        );
    }

    public function tearDown(): void
    {
        unset(
            $this->characterRepository,
            $this->getOneCharacterQueryHandler
        );
    }

    /** @test */
    public function should_find_a_character(): void
    {
        $query = GetOneCharacterQueryMother::random();
        $character = CharacterMother::random();

        $this->characterRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($character);

        $this->getOneCharacterQueryHandler->__invoke($query);
    }

    /** @test */
    public function should_fail_when_character_does_not_exist(): void
    {
        $this->expectException(CharacterDoesNotExist::class);

        $query = GetOneCharacterQueryMother::random();

        $this->characterRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $this->getOneCharacterQueryHandler->__invoke($query);
    }
}
