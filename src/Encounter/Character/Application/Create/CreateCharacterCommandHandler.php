<?php

declare(strict_types=1);

namespace Encounter\Character\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\CharacterArmorClass;
use Encounter\Character\Domain\CharacterHP;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterImg;
use Encounter\Character\Domain\CharacterLevel;
use Encounter\Character\Domain\CharacterName;
use Encounter\Character\Domain\CharacterSpeed;
use Encounter\Character\Domain\PlayerName;
use Shared\Domain\Bus\Command\CommandHandler;

final class CreateCharacterCommandHandler implements CommandHandler
{
    public function __construct(
        private CreateCharacter $createCharacter
    ) {}

    public function __invoke(CreateCharacterCommand $command): void
    {
        $this->createCharacter->__invoke(
            new CharacterId($command->characterId()),
            new CharacterName($command->characterName()),
            new PlayerName($command->playerName()),
            new CampaignId($command->campaignId()),
            new CharacterLevel($command->level()),
            new CharacterArmorClass($command->ac()),
            new CharacterHP($command->hp()),
            new CharacterSpeed($command->speed()),
            new CharacterImg($command->img())
        );
    }
}
