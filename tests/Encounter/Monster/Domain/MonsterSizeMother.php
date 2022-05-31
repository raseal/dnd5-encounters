<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterSize;
use Faker\Factory;

final class MonsterSizeMother
{
    public static function create(string $size): MonsterSize
    {
        return new MonsterSize($size);
    }

    public static function random(): MonsterSize
    {
        return self::create(
            Factory::create()->randomKey(MonsterSize::VALID_TYPES)
        );
    }
}
