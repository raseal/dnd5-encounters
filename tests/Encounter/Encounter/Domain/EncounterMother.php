<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

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
use Test\Encounter\Campaign\Domain\CampaignIdMother;

final class EncounterMother
{
    public static function create(
        EncounterId $encounterId,
        CampaignId $campaignId,
        Difficulty $difficulty,
        EncounterInProgress $inProgress,
        EncounterName $encounterName,
        TotalExperience $totalExperience,
        ExperiencePerPlayer $experiencePerPlayer,
        RoundNumber $roundNumber,
        TurnNumber $turnNumber
    ): Encounter {
        return new Encounter(
            $encounterId,
            $campaignId,
            $difficulty,
            $inProgress,
            $encounterName,
            $totalExperience,
            $experiencePerPlayer,
            $roundNumber,
            $turnNumber
        );
    }

    public static function random(): Encounter
    {
        return self::create(
            EncounterIdMother::random(),
            CampaignIdMother::random(),
            DifficultyMother::random(),
            EncounterInProgressMother::random(),
            EncounterNameMother::random(),
            TotalExperienceMother::random(),
            ExperiencePerPlayerMother::random(),
            RoundNumberMother::random(),
            TurnNumberMother::random()
        );
    }
}
