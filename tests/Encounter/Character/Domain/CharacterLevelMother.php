<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterLevel;
use Faker\Factory;

final class CharacterLevelMother
{
    public static function create(int $level): CharacterLevel
    {
        return new CharacterLevel($level);
    }

    public static function random(): CharacterLevel
    {
        return self::create(Factory::create()->numberBetween(1, 20));
    }
}
