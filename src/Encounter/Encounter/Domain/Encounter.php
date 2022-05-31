<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\CharacterIds;
use Encounter\Monster\Domain\Monsters;
use Shared\Domain\Aggregate\AggregateRoot;

final class Encounter extends AggregateRoot
{
    private Monsters $monsters;
    private CharacterIds $characterIds;

    public function __construct(
        private EncounterId $encounterId,
        private CampaignId $campaignId,
        private ?Difficulty $difficulty,
        private EncounterInProgress $inProgress,
        private EncounterName $encounterName,
        private ?TotalExperience $totalExperience,
        private ?ExperiencePerPlayer $experiencePerPlayer,
        private RoundNumber $roundNumber,
        private TurnNumber $turnNumber
    ) {
        $this->monsters = new Monsters([]);
        $this->characterIds = new CharacterIds([]);
        $this->difficulty = $this->difficulty ?? Difficulty::fromNone();
        $this->totalExperience = $this->totalExperience ?? new TotalExperience(0);
        $this->experiencePerPlayer = $this->experiencePerPlayer ?? new ExperiencePerPlayer(0);
    }

    public function addMonsters(Monsters $monsters): void
    {
        foreach ($monsters as $monster) {
            $this->monsters->add($monster);
        }
    }

    public function addPlayersIds(CharacterIds $characterIds): void
    {
        foreach ($characterIds as $characterId) {
            $this->characterIds->add($characterId);
        }
    }

    public function encounterId(): EncounterId
    {
        return $this->encounterId;
    }

    public function campaignId(): CampaignId
    {
        return $this->campaignId;
    }

    public function inProgress(): EncounterInProgress
    {
        return $this->inProgress;
    }

    public function encounterName(): EncounterName
    {
        return $this->encounterName;
    }

    public function roundNumber(): RoundNumber
    {
        return $this->roundNumber;
    }

    public function turnNumber(): TurnNumber
    {
        return $this->turnNumber;
    }

    public function monsters(): Monsters
    {
        return $this->monsters;
    }

    public function characterIds(): CharacterIds
    {
        return $this->characterIds;
    }

    public function difficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function totalExperience(): TotalExperience
    {
        return $this->totalExperience;
    }

    public function experiencePerPlayer(): ExperiencePerPlayer
    {
        return $this->experiencePerPlayer;
    }
}