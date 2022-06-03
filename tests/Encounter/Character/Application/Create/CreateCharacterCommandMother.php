<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Application\Create;

use Encounter\Character\Application\Create\CreateCharacterCommand;
use Faker\Factory;

final class CreateCharacterCommandMother
{
    public static function create(
        string $characterId,
        string $characterName,
        string $playerName,
        string $campaignId,
        int $level,
        int $ac,
        int $hp,
        int $speed,
        string $img
    ): CreateCharacterCommand {
        return new CreateCharacterCommand(
            $characterId,
            $characterName,
            $playerName,
            $campaignId,
            $level,
            $ac,
            $hp,
            $speed,
            $img
        );
    }

    public static function random(): CreateCharacterCommand
    {
        return self::create(
            Factory::create()->uuid(),
            Factory::create()->name(),
            Factory::create()->name(),
            Factory::create()->uuid(),
            Factory::create()->numberBetween(1, 20),
            Factory::create()->numberBetween(10, 30),
            Factory::create()->numberBetween(10, 300),
            Factory::create()->numberBetween(20, 70),
            Factory::create()->text(10)
        );
    }

    public static function fromCharacterLevel(int $level): CreateCharacterCommand
    {
        return self::create(
            Factory::create()->uuid(),
            Factory::create()->name(),
            Factory::create()->name(),
            Factory::create()->uuid(),
            $level,
            Factory::create()->numberBetween(10, 30),
            Factory::create()->numberBetween(10, 300),
            Factory::create()->numberBetween(20, 70),
            Factory::create()->text(10)
        );
    }
}
