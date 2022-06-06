<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\CharacterId;
use Encounter\Encounter\Domain\CharacterIds;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterInProgress;
use Encounter\Encounter\Domain\EncounterName;
use Encounter\Encounter\Domain\MonsterIds;
use Encounter\Encounter\Domain\RoundNumber;
use Encounter\Encounter\Domain\TurnNumber;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\SourceBook;
use Shared\Domain\Bus\Command\CommandHandler;

final class CreateEncounterCommandHandler implements CommandHandler
{
    private const DEFAULT_TURN_NUMBER = 0;
    private const DEFAULT_ROUND_NUMBER = 0;

    public function __construct(
        private CreateEncounter $createEncounter
    ) {}

    public function __invoke(CreateEncounterCommand $command): void
    {
        $this->createEncounter->__invoke(
            new EncounterId($command->encounterId()),
            new CampaignId($command->campaignId()),
            new EncounterInProgress($command->inProgress()),
            new EncounterName($command->encounterName()),
            new RoundNumber(self::DEFAULT_ROUND_NUMBER),
            new TurnNumber(self::DEFAULT_TURN_NUMBER),
            $this->parseMonsterIds($command->monsterIds()),
            $this->parseCharacterIds($command->playerIds())
        );
    }

    private function parseMonsterIds(array $monsters): MonsterIds
    {
        $collection = new MonsterIds([]);

        foreach ($monsters as $data) {
            $monsterId = new MonsterId(
                new MonsterName($data['monsterName']),
                new SourceBook($data['sourceBook'])
            );

            for ($i = 0; $i < $data['quantity']; $i++) {
                $collection->add($monsterId);
            }
        }

        return $collection;
    }

    private function parseCharacterIds(array $players): CharacterIds
    {
        $collection = new CharacterIds([]);

        foreach ($players as $player) {
            $collection->add(new CharacterId($player));
        }

        return $collection;
    }
}
