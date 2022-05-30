<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterIds;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterInProgress;
use Encounter\Encounter\Domain\EncounterName;
use Encounter\Encounter\Domain\RoundNumber;
use Encounter\Encounter\Domain\TurnNumber;
use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\InitiativeBonus;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterArmorClass;
use Encounter\Monster\Domain\MonsterHPAverage;
use Encounter\Monster\Domain\MonsterHPMax;
use Encounter\Monster\Domain\MonsterImg;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\Monsters;
use Encounter\Monster\Domain\MonsterSize;
use Encounter\Monster\Domain\Page;
use Encounter\Monster\Domain\SourceBook;
use Shared\Domain\Bus\Command\CommandHandler;

final class CreateEncounterCommandHandler implements CommandHandler
{
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
            new RoundNumber($command->round()),
            new TurnNumber($command->turn()),
            $this->parseMonsters($command->monsters()),
            $this->parseCharacters($command->players())
        );
    }

    private function parseMonsters(array $monsters): Monsters
    {
        $collection = new Monsters([]);

        foreach ($monsters as $monster) {
            for($i = 0; $i < $monster['quantity']; $i++) {
                $collection->add(
                    new Monster(
                        null,
                        new MonsterName($monster['name']),
                        new SourceBook($monster['sourceBook']),
                        new Page((int) $monster['page']),
                        new MonsterSize($monster['size']),
                        new ChallengeRating((int) $monster['cr']),
                        new MonsterImg($monster['img']),
                        new InitiativeBonus((int) $monster['initBonus']),
                        new MonsterHPAverage((int) $monster['hpAvg']),
                        new MonsterHPMax((int) $monster['hpMax']),
                        new MonsterArmorClass((int) $monster['ac'])
                    )
                );
            }
        }

        return $collection;
    }

    private function parseCharacters(array $players): CharacterIds
    {
        $collection = new CharacterIds([]);

        foreach ($players as $player) {
            $collection->add(
                new CharacterId($player)
            );
        }

        return $collection;
    }
}
