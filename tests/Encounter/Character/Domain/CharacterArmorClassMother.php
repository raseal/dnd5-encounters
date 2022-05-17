<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterArmorClass;
use Faker\Factory;

final class CharacterArmorClassMother
{
    public static function create(int $ac): CharacterArmorClass
    {
        return new CharacterArmorClass($ac);
    }

    public static function random(): CharacterArmorClass
    {
        return self::create(Factory::create()->numberBetween(10, 30));
    }
}
