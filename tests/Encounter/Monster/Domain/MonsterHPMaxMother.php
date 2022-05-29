<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterHPMax;
use Faker\Factory;

final class MonsterHPMaxMother
{
    public static function create(int $hp): MonsterHPMax
    {
        return new MonsterHPMax($hp);
    }

    public static function random(): MonsterHPMax
    {
        return self::create(Factory::create()->numberBetween(10, 800));
    }
}
