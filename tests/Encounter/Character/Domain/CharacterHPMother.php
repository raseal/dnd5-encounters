<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterHP;
use Faker\Factory;

final class CharacterHPMother
{
    public static function create(int $hp): CharacterHP
    {
        return new CharacterHP($hp);
    }

    public static function random(): CharacterHP
    {
        return self::create(Factory::create()->numberBetween(10, 250));
    }
}
