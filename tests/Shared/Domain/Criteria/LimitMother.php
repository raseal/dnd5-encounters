<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria;

use Faker\Factory;
use Shared\Domain\Criteria\Limit;

final class LimitMother
{
    public static function create(int $value): Limit
    {
        return new Limit($value);
    }

    public static function random(): Limit
    {
        return self::create(Factory::create()->numberBetween(1, 50));
    }
}
