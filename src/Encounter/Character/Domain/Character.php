<?php

declare(strict_types=1);

namespace Encounter\Character\Domain;

use Encounter\Campaign\Domain\CampaignId;

final class Character
{
    public function __construct(
        private CharacterId $characterId,
        private CharacterName $characterName,
        private PlayerName $playerName,
        private CampaignId $campaignId,
        private CharacterLevel $characterLevel,
        private CharacterArmorClass $characterArmorClass,
        private CharacterHP $characterHP,
        private CharacterSpeed $characterSpeed,
        private CharacterImg $characterImg
    ) {}

    public function characterId(): CharacterId
    {
        return $this->characterId;
    }

    public function characterName(): CharacterName
    {
        return $this->characterName;
    }

    public function playerName(): PlayerName
    {
        return $this->playerName;
    }

    public function campaignId(): CampaignId
    {
        return $this->campaignId;
    }

    public function characterLevel(): CharacterLevel
    {
        return $this->characterLevel;
    }

    public function characterArmorClass(): CharacterArmorClass
    {
        return $this->characterArmorClass;
    }

    public function characterHP(): CharacterHP
    {
        return $this->characterHP;
    }

    public function characterSpeed(): CharacterSpeed
    {
        return $this->characterSpeed;
    }

    public function characterImg(): CharacterImg
    {
        return $this->characterImg;
    }
}
