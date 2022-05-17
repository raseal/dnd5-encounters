<?php

declare(strict_types=1);

namespace Encounter\Character\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\CharacterArmorClass;
use Encounter\Character\Domain\CharacterHP;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterImg;
use Encounter\Character\Domain\CharacterLevel;
use Encounter\Character\Domain\CharacterName;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\CharacterSpeed;
use Encounter\Character\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Domain\Exception\CharacterAlreadyExists;
use Encounter\Character\Domain\PlayerName;

final class CreateCharacter
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private CampaignRepository $campaignRepository
    ) {}

    public function __invoke(
        CharacterId $characterId,
        CharacterName $characterName,
        PlayerName $playerName,
        CampaignId $campaignId,
        CharacterLevel $characterLevel,
        CharacterArmorClass $characterArmorClass,
        CharacterHP $characterHP,
        CharacterSpeed $characterSpeed,
        CharacterImg $characterImg
    ): void {
        $this->ensureCharacterDoesNotExist($characterId);
        $this->ensureCampaignExists($campaignId);

        $this->characterRepository->save(
            new Character(
                $characterId,
                $characterName,
                $playerName,
                $campaignId,
                $characterLevel,
                $characterArmorClass,
                $characterHP,
                $characterSpeed,
                $characterImg
            )
        );
    }

    private function ensureCharacterDoesNotExist(CharacterId $characterId): void
    {
        $character = $this->characterRepository->findById($characterId);

        if (null !== $character) {
            throw new CharacterAlreadyExists($characterId->value());
        }
    }

    private function ensureCampaignExists(CampaignId $campaignId): void
    {
        $campaign = $this->campaignRepository->findById($campaignId);

        if (null === $campaign) {
            throw new CampaignDoesNotExist($campaignId->value());
        }
    }
}
