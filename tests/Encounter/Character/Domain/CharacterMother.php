<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\CharacterArmorClass;
use Encounter\Character\Domain\CharacterHP;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterImg;
use Encounter\Character\Domain\CharacterLevel;
use Encounter\Character\Domain\CharacterName;
use Encounter\Character\Domain\CharacterSpeed;
use Encounter\Character\Domain\PlayerName;
use Test\Encounter\Campaign\Domain\CampaignIdMother;

final class CharacterMother
{
    public static function create(
        CharacterId $characterId,
        CharacterName $characterName,
        PlayerName $playerName,
        CampaignId $campaignId,
        CharacterLevel $characterLevel,
        CharacterArmorClass $characterArmorClass,
        CharacterHP $characterHP,
        CharacterSpeed $characterSpeed,
        CharacterImg $characterImg
    ): Character {
        return new Character(
            $characterId,
            $characterName,
            $playerName,
            $campaignId,
            $characterLevel,
            $characterArmorClass,
            $characterHP,
            $characterSpeed,
            $characterImg
        );
    }

    public static function random(): Character
    {
        return self::create(
            CharacterIdMother::random(),
            CharacterNameMother::random(),
            PlayerNameMother::random(),
            CampaignIdMother::random(),
            CharacterLevelMother::random(),
            CharacterArmorClassMother::random(),
            CharacterHPMother::random(),
            CharacterSpeedMother::random(),
            CharacterImgMother::random()
        );
    }

    public static function fromCampaignId(CampaignId $campaignId): Character
    {
        return self::create(
            CharacterIdMother::random(),
            CharacterNameMother::random(),
            PlayerNameMother::random(),
            $campaignId,
            CharacterLevelMother::random(),
            CharacterArmorClassMother::random(),
            CharacterHPMother::random(),
            CharacterSpeedMother::random(),
            CharacterImgMother::random()
        );
    }
}
