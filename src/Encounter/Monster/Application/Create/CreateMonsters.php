<?php

declare(strict_types=1);

namespace Encounter\Monster\Application\Create;

use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterRepository;
use Encounter\Monster\Domain\Monsters;

final class CreateMonsters
{
    public function __construct(
        private MonsterRepository $monsterRepository
    ) {}

    public function __invoke(Monsters $monsters): void
    {
        $monstersToSave = [];

        /** @var Monster $monster */
        foreach ($monsters as $monster) {
            if (null === $this->monsterRepository->findbyId($monster->monsterId())) {
                $monstersToSave[$monster->monsterId()->value()] = $monster;
            }
        }

        foreach ($monstersToSave as $monster) {
            $this->monsterRepository->save($monster);
        }
    }
}
