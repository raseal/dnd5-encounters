<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria;

use Faker\Factory;
use Shared\Domain\Criteria\Offset;

final class OffsetMother
{
    public static function create(int $value): Offset
    {
        return new Offset($value);
    }

    public static function randomFromLimit(int $limit): Offset
    {
        return self::create($limit * Factory::create()->numberBetween(0, 10));
    }
}
