<?php

declare(strict_types=1);

namespace Encounter\Character\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterRepository;

final class DBALCharacterRepository implements CharacterRepository
{
    public function __construct(
        private Connection $connection,
        private DBALCharacterHydrator $characterHydrator
    ) {}

    public function save(Character $character): void
    {
        $queryBuilder = new QueryBuilder($this->connection);
        $queryBuilder
            ->insert('player_character')
            ->values([
                'id' => ':id',
                'campaign_id' => ':campaignId',
                'name' => ':characterName',
                'player_name' => ':playerName',
                'level' => ':characterLevel',
                'ac' => ':characterArmorClass',
                'hp' => ':characterHP',
                'speed' => ':characterSpeed',
                'img' => ':characterImg',
            ])
            ->setParameters([
                'id'=> $character->characterId()->value(),
                'campaignId'=> $character->campaignId()->value(),
                'characterName'=> $character->characterName()->value(),
                'playerName'=> $character->playerName()->value(),
                'characterLevel'=> $character->characterLevel()->value(),
                'characterArmorClass'=> $character->characterArmorClass()->value(),
                'characterHP'=> $character->characterHP()->value(),
                'characterSpeed'=> $character->characterSpeed()->value(),
                'characterImg'=> $character->characterImg()->value(),
            ])
            ->executeQuery();
    }

    public function findById(CharacterId $characterId): ?Character
    {
        $qb = new QueryBuilder($this->connection);
        $result = $qb
            ->select('id, campaign_id, name, player_name, level, ac, hp, speed, img')
            ->from('player_character')
            ->where('id = :id')
            ->setParameter('id', $characterId->value())
            ->executeQuery();

        if (0 === $result->rowCount()) {
            return null;
        }

        $data = $result->fetchAssociative();

        return $this->characterHydrator->hydrate($data);
    }
}
