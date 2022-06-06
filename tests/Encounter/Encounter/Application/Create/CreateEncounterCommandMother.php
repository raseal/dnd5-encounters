<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Application\Create;

use Encounter\Encounter\Application\Create\CreateEncounterCommand;
use Faker\Factory;
use Test\Encounter\Character\Domain\CharacterIdMother;
use Test\Encounter\Monster\Domain\MonsterNameMother;
use Test\Encounter\Monster\Domain\SourceBookMother;

final class CreateEncounterCommandMother
{
    public static function create(
        string $encounterId,
        string $campaignId,
        bool $inProgress,
        array $monsters,
        array $players,
        string $encounterName
    ): CreateEncounterCommand {
        return new CreateEncounterCommand(
            $encounterId,
            $campaignId,
            $inProgress,
            $monsters,
            $players,
            $encounterName
        );
    }

    public static function random(): CreateEncounterCommand
    {
        return self::create(
            Factory::create()->uuid(),
            Factory::create()->uuid(),
            Factory::create()->boolean(),
            self::generateRandomMonsters(),
            self::generateRandomCharacterIds(),
            Factory::create()->name()
        );
    }

    public static function fromCampaignId(string $campaignId): CreateEncounterCommand
    {
        return self::create(
            Factory::create()->uuid(),
            $campaignId,
            Factory::create()->boolean(),
            self::generateRandomMonsters(),
            self::generateRandomCharacterIds(),
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
            $monsters[] = [
                'monsterName' => MonsterNameMother::random()->value(),
                'sourceBook' => SourceBookMother::random()->value(),
                'quantity' => Factory::create()->numberBetween(1, 3),
            ];
        }

        return $monsters;
    }

    private static function generateRandomCharacterIds(): array
    {
        $characters = [];
        $charactersNumber = Factory::create()->numberBetween(1, 3);

        for ($i = 0; $i < $charactersNumber; $i++) {
            $characters[] = CharacterIdMother::random()->value();
        }

        return $characters;
    }
}
