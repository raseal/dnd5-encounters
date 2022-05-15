<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria\Filter;

use Faker\Factory;
use Shared\Domain\Criteria\Filter\FilterOperator;

final class FilterOperatorMother
{
    public static function create(string $operator): FilterOperator
    {
        return new FilterOperator($operator);
    }

    public static function random(): FilterOperator
    {
        return self::create(
            Factory::create()->randomElement(FilterOperator::VALID_OPERATORS)
        );
    }

    public static function eq(): FilterOperator
    {
        return self::create(FilterOperator::EQ);
    }

    public static function like(): FilterOperator
    {
        return self::create(FilterOperator::LIKE);
    }
}
