<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Encounter\Application\Create\CreateEncounterCommand;
use Faker\Factory;
use Test\Encounter\Character\Domain\CharacterIdMother;
use Test\Encounter\Monster\Domain\MonsterMother;

final class CreateEncounterCommandMother
{
    public static function create(
        string $encounterId,
        string $campaignId,
        bool $inProgress,
        array $monsters,
        array $players,
        string $encounterName,
        int $round,
        int $turn
    ): CreateEncounterCommand {
        return new CreateEncounterCommand(
            $encounterId,
            $campaignId,
            $inProgress,
            $monsters,
            $players,
            $encounterName,
            $round,
            $turn
        );
    }

    public static function random(): CreateEncounterCommand
    {
        return self::create(
            Factory::create()->uuid(),
            Factory::create()->uuid(),
            Factory::create()->boolean(),
            self::generateRandomMonsters(),
            self::generateRandomCharacters(),
            Factory::create()->name(),
            Factory::create()->numberBetween(0, 15),
            Factory::create()->numberBetween(0, 15)
        );
    }

    public static function fromCampaignId(CampaignId $campaignId): CreateEncounterCommand
    {
        return self::create(
            Factory::create()->uuid(),
            $campaignId->value(),
            Factory::create()->boolean(),
            self::generateRandomMonsters(),
            self::generateRandomCharacters(),
            Factory::create()->name(),
            Factory::create()->numberBetween(0, 15),
            Factory::create()->numberBetween(0, 15)
        );
    }

    private static function generateRandomMonsters(): array
    {
        $monsters = [];
        $monstersNumber = Factory::create()->numberBetween(1, 4);

        for ($i = 0; $i < $monstersNumber; $i++) {
            $monster = MonsterMother::random();

            $monsters[] = [
                'name' => $monster->monsterName()->value(),
                'sourceBook' => $monster->sourceBook()->value(),
                'page' => $monster->page()->value(),
                'size' => $monster->monsterSize()->value(),
                'cr' => $monster->challengeRating()->value(),
                'img' => $monster->monsterImg()->value(),
                'initBonus' => $monster->initiativeBonus()->value(),
                'hpAvg' => $monster->HPAverage()->value(),
                'hpMax' => $monster->HPMax()->value(),
                'ac' => $monster->armorClass()->value(),
                'quantity' => Factory::create()->numberBetween(1, 3),
            ];
        }

        return $monsters;
    }

    private static function generateRandomCharacters(): array
    {
        $characters = [];
        $charactersNumber = Factory::create()->numberBetween(1, 3);

        for ($i = 0; $i < $charactersNumber; $i++) {
            $characters[] = CharacterIdMother::random()->value();
        }

        return $characters;
    }
}
