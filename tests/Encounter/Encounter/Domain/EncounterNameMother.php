<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\EncounterName;
use Faker\Factory;

final class EncounterNameMother
{
    public static function create(string $name): EncounterName
    {
        return new EncounterName($name);
    }

    public static function random(): EncounterName
    {
        return self::create(Factory::create()->name());
    }
}
