<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterName;
use Faker\Factory;

final class CharacterNameMother
{
    public static function create(string $name): CharacterName
    {
        return new CharacterName($name);
    }

    public static function random(): CharacterName
    {
        return self::create(Factory::create()->name());
    }
}
