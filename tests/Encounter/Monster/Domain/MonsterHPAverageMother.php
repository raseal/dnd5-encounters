<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterHPAverage;
use Faker\Factory;

final class MonsterHPAverageMother
{
    public static function create(int $hp): MonsterHPAverage
    {
        return new MonsterHPAverage($hp);
    }

    public static function random(): MonsterHPAverage
    {
        return self::create(Factory::create()->numberBetween(10, 700));
    }
}
