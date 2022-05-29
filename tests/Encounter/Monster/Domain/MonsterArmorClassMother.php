<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterArmorClass;
use Faker\Factory;

final class MonsterArmorClassMother
{
    public static function create(int $ac): MonsterArmorClass
    {
        return new MonsterArmorClass($ac);
    }

    public static function random(): MonsterArmorClass
    {
        return self::create(Factory::create()->numberBetween(10, 40));
    }
}
