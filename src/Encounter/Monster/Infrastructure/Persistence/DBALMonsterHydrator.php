<?php

declare(strict_types=1);

namespace Encounter\Monster\Infrastructure\Persistence;

use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\InitiativeBonus;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterArmorClass;
use Encounter\Monster\Domain\MonsterHPAverage;
use Encounter\Monster\Domain\MonsterHPMax;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterImg;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\MonsterSize;
use Encounter\Monster\Domain\Page;
use Encounter\Monster\Domain\SourceBook;

final class DBALMonsterHydrator
{
    public function hydrate(array $data): Monster
    {
        return new Monster(...$this->extractProperties($data));
    }

    private function extractProperties(array $data): array
    {
        return [
            'monsterId' => new MonsterId($data['id']),
            'monsterName' => new MonsterName($data['name']),
            'sourceBook' => new SourceBook($data['sourcebook']),
            'page' => new Page((int) $data['page']),
            'monsterSize' => new MonsterSize($data['size']),
            'challengeRating' => new ChallengeRating((float) $data['cr']),
            'monsterImg' => new MonsterImg($data['img']),
            'initiativeBonus' => new InitiativeBonus((int) $data['init_bonus']),
            'HPAverage' => new MonsterHPAverage((int) $data['hp_avg']),
            'HPMax' => new MonsterHPMax((int) $data['hp_max']),
            'armorClass' => new MonsterArmorClass((int) $data['ac']),
        ];
    }
}
