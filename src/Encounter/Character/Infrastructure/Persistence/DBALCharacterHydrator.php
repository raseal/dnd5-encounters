<?php

declare(strict_types=1);

namespace Encounter\Character\Infrastructure\Persistence;

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

final class DBALCharacterHydrator
{
    public function hydrate(array $data): Character
    {
        return new Character(...$this->extractProperties($data));
    }

    private function extractProperties(array $data): array
    {
        return [
            'characterId' => new CharacterId($data['id']),
            'characterName' => new CharacterName($data['name']) ,
            'playerName' => new PlayerName($data['player_name']),
            'campaignId' => new CampaignId($data['campaign_id']),
            'characterLevel' => new CharacterLevel((int) $data['level']),
            'characterArmorClass' => new CharacterArmorClass((int) $data['ac']),
            'characterHP' => new CharacterHP((int) $data['hp']),
            'characterSpeed' => new CharacterSpeed((int) $data['speed']),
            'characterImg' => new CharacterImg($data['img']),
        ];
    }
}
