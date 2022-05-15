<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria\Filter;

use Faker\Factory;
use Shared\Domain\Criteria\Filter\FilterValue;

final class FilterValueMother
{
    public static function create(string $value): FilterValue
    {
        return new FilterValue($value);
    }

    public static function random(): FilterValue
    {
        return self::create(Factory::create()->randomAscii());
    }
}
