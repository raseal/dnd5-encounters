<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterName;
use Faker\Factory;

final class MonsterNameMother
{
    public static function create(string $name): MonsterName
    {
        return new MonsterName($name);
    }

    public static function random(): MonsterName
    {
        return self::create(Factory::create()->name());
    }
}
