<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Infrastructure\Persistence;

use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Infrastructure\Persistence\DBALMonsterHydrator;
use Encounter\Monster\Infrastructure\Persistence\DBALMonsterRepository;
use Test\DBALTestCase;
use Test\Encounter\Monster\Domain\MonsterMother;

final class DBALMonsterRepositoryTest extends DBALTestCase
{
    private DBALMonsterRepository $monsterRepository;

    public function setUp(): void
    {
        $this->monsterRepository = new DBALMonsterRepository(
            $this->connection(),
            new DBALMonsterHydrator()
        );
        parent::setUp();
    }

    /** @test */
    public function should_save_a_monster(): void
    {
        $monster = MonsterMother::random();

        $this->monsterRepository->save($monster);
    }

    public function should_get_a_monster(): void
    {
        $monster = MonsterMother::random();

        $this->monsterRepository->save($monster);

        $storedMonster = $this->monsterRepository->findById($monster->monsterId());

        $this->assertInstanceOf(Monster::class, $storedMonster);
        $this->assertEquals($monster, $storedMonster);
    }
}
