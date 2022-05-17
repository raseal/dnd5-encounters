<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterSpeed;
use Faker\Factory;

final class CharacterSpeedMother
{
    public static function create(int $speed): CharacterSpeed
    {
        return new CharacterSpeed($speed);
    }

    public static function random(): CharacterSpeed
    {
        return self::create(Factory::create()->numberBetween(10, 70));
    }
}
