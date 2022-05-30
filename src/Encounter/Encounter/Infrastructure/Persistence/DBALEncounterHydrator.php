<?php

declare(strict_types=1);

namespace Encounter\Encounter\Infrastructure\Persistence;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Encounter\Domain\Difficulty;
use Encounter\Encounter\Domain\Encounter;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterInProgress;
use Encounter\Encounter\Domain\EncounterName;
use Encounter\Encounter\Domain\ExperiencePerPlayer;
use Encounter\Encounter\Domain\RoundNumber;
use Encounter\Encounter\Domain\TotalExperience;
use Encounter\Encounter\Domain\TurnNumber;

final class DBALEncounterHydrator
{
    public function hydrate(array $data): Encounter
    {
        return new Encounter(...$this->extractProperties($data));
    }

    private function extractProperties(array $data): array
    {
        return [
            'encounterId' => new EncounterId($data['id']),
            'campaignId' => new CampaignId($data['campaign_id']),
            'difficulty' => new Difficulty($data['difficulty']),
            'inProgress' => new EncounterInProgress((bool) $data['in_progress']),
            'encounterName' => new EncounterName($data['name']),
            'totalExperience' => new TotalExperience((int) $data['total_experience']),
            'experiencePerPlayer' => new ExperiencePerPlayer((int) $data['experience_per_player']),
            'roundNumber' => new RoundNumber((int) $data['current_round']),
            'turnNumber' => new TurnNumber((int) $data['current_turn']),
        ];
    }
}
