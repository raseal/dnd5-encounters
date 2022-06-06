<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\Characters;
use Encounter\Monster\Domain\Monsters;
use Shared\Domain\Aggregate\AggregateRoot;

final class Encounter extends AggregateRoot
{
    private Monsters $monsters;
    private Characters $characters;

    public function __construct(
        private EncounterId $encounterId,
        private CampaignId $campaignId,
        private Difficulty $difficulty,
        private EncounterInProgress $inProgress,
        private EncounterName $encounterName,
        private TotalExperience $totalExperience,
        private ExperiencePerPlayer $experiencePerPlayer,
        private RoundNumber $roundNumber,
        private TurnNumber $turnNumber
    ) {
        $this->monsters = new Monsters([]);
        $this->characters = new Characters([]);
    }

    public function addMonsters(Monsters $monsters): void
    {
        foreach ($monsters as $monster) {
            $this->monsters->add($monster);
        }

        $this->calculateDifficulty();
        $this->calculateExperience();
    }

    public function addCharacters(Characters $characters): void
    {
        foreach ($characters as $character) {
            $this->characters->add($character);
        }

        $this->calculateDifficulty();
        $this->calculateExperience();
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

    public function characters(): Characters
    {
        return $this->characters;
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

    private function calculateDifficulty(): void
    {
        $this->difficulty = Difficulty::fromParticipants($this->characters, $this->monsters);
    }

    private function calculateExperience(): void
    {
        if ($this->characters->count() > 0) {
            $this->totalExperience = TotalExperience::fromMonsters($this->monsters);
            $this->experiencePerPlayer = new ExperiencePerPlayer(
                (int)($this->totalExperience()->value() / $this->characters->count())
            );
        }
    }
}
