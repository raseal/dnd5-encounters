<?php

declare(strict_types=1);

namespace Encounter\Encounter\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Encounter\Character\Domain\CharacterId;
use Encounter\Encounter\Domain\Encounter;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterRepository;
use Encounter\Monster\Domain\Monster;
use Shared\Domain\ValueObject\Uuid;

final class DBALEncounterRepository implements EncounterRepository
{
    private const MONSTER_TYPE = 'M';
    private const PLAYER_TYPE = 'P';

    public function __construct(
        private Connection $connection,
        private DBALEncounterHydrator $encounterHydrator
    ) {}

    public function findById(EncounterId $encounterId): ?Encounter
    {
        $qb = new QueryBuilder($this->connection);
        $result = $qb
            ->select('id, campaign_id, difficulty, in_progress, name, total_experience, experience_per_player, current_round, current_turn')
            ->from('encounter')
            ->where('id = :id')
            ->setParameter('id', $encounterId->value())
            ->executeQuery();

        if (0 === $result->rowCount()) {
            return null;
        }

        $data = $result->fetchAssociative();

        return $this->encounterHydrator->hydrate($data);

    }

    public function save(Encounter $encounter): void
    {
        $this->connection->beginTransaction();

        $this->saveEncounter($encounter);
        $this->assignParticipants($encounter);

        $this->connection->commit();
    }

    private function saveEncounter(Encounter $encounter): void
    {
        $queryBuilder = new QueryBuilder($this->connection);
        $queryBuilder
            ->insert('encounter')
            ->values([
                'id' => ':id',
                'campaign_id' => ':campaignId',
                'difficulty' => ':difficulty',
                'in_progress' => ':inProgress',
                'name' => ':name',
                'total_experience' => ':totalExperience',
                'experience_per_player' => ':experiencePerPlayer',
                'current_round' => ':currentRound',
                'current_turn' => ':currentTurn',
            ])
            ->setParameters([
                'id' => $encounter->encounterId()->value(),
                'campaignId' => $encounter->campaignId()->value(),
                'difficulty' => $encounter->difficulty()->value(),
                'inProgress' => $encounter->inProgress()->value() ? 1 : 0,
                'name' => $encounter->encounterName()->value(),
                'totalExperience' => $encounter->totalExperience()->value(),
                'experiencePerPlayer' => $encounter->experiencePerPlayer()->value(),
                'currentRound' => $encounter->roundNumber()->value(),
                'currentTurn' => $encounter->turnNumber()->value(),
            ])
            ->executeQuery();
    }

    private function assignParticipants(Encounter $encounter): void
    {
        /** @var Monster $monster */
        foreach ($encounter->monsters() as $monster) {
            $this->assignParticipant(
                $encounter->encounterId(),
                $monster->monsterId()->value(),
                self::MONSTER_TYPE,
                $monster->HPMax()->value(),
                $monster->HPMax()->value()
            );
        }

        /** @var CharacterId $characterId */
        foreach ($encounter->characterIds() as $characterId) {
            $this->assignParticipant(
                $encounter->encounterId(),
                $characterId->value(),
                self::PLAYER_TYPE,
                0,
                0
            );
        }
    }

    private function assignParticipant(
        EncounterId $encounterId,
        string $participantId,
        string $participantType,
        int $maxHP,
        int $currentHP
    ): void {
        $queryBuilder = new QueryBuilder($this->connection);
        $queryBuilder
            ->insert('encounter_participant')
            ->values([
                'id' => ':id',
                'encounter_id' => ':encounterId',
                'participant_id' => ':participantId',
                'participant_type' => ':participantType',
                'initiative_roll' => ':initiativeRoll',
                'max_hp' => ':maxHP',
                'current_hp' => ':currentHP',
            ])
            ->setParameters([
                'id' => Uuid::random()->value(),
                'encounterId' => $encounterId->value(),
                'participantId' => $participantId,
                'participantType' => $participantType,
                'initiativeRoll' => 0,
                'maxHP' => $maxHP,
                'currentHP' => $currentHP,
            ])
            ->executeQuery();
    }
}
