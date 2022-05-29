<?php

declare(strict_types=1);

namespace Encounter\Monster\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterRepository;

final class DBALMonsterRepository implements MonsterRepository
{
    public function __construct(
        private Connection $connection,
        private DBALMonsterHydrator $monsterHydrator
    ) {}

    public function findbyId(MonsterId $monsterId): ?Monster
    {
        $qb = new QueryBuilder($this->connection);
        $result = $qb
            ->select('id, name, sourcebook, page, size, cr, img, init_bonus, hp_avg, hp_max, ac')
            ->from('monster')
            ->where('id = :id')
            ->setParameter('id', $monsterId->value())
            ->executeQuery();

        if (0 === $result->rowCount()) {
            return null;
        }

        $data = $result->fetchAssociative();

        return $this->monsterHydrator->hydrate($data);
    }

    public function save(Monster $monster): void
    {
        $queryBuilder = new QueryBuilder($this->connection);
        $queryBuilder
            ->insert('monster')
            ->values([
                'id' => ':id',
                'name' => ':monsterName',
                'sourcebook' => ':sourcebook',
                'page' => ':page',
                'size' => ':monsterSize',
                'cr' => ':monsterChallengeRating',
                'img' => ':monsterImg',
                'init_bonus' => ':initiativeBonus',
                'hp_avg' => ':monsterHPAvg',
                'hp_max' => ':monsterHPMax',
                'ac' => ':monsterArmorClass',
            ])
            ->setParameters([
                'id'=> $monster->monsterId()->value(),
                'monsterName'=> $monster->monsterName()->value(),
                'sourcebook' => $monster->sourceBook()->value(),
                'page' => $monster->page()->value(),
                'monsterSize' => $monster->monsterSize()->value(),
                'monsterChallengeRating' => $monster->challengeRating()->value(),
                'monsterImg'=> $monster->monsterImg()->value(),
                'initiativeBonus'=> $monster->initiativeBonus()->value(),
                'monsterHPAvg' => $monster->HPAverage()->value(),
                'monsterHPMax' => $monster->HPMax()->value(),
                'monsterArmorClass'=> $monster->armorClass()->value(),
            ])
            ->executeQuery();
    }
}
