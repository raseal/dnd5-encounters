<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria\Filter;

use Shared\Domain\Criteria\Filter\Filters;

final class FiltersMother
{
    public static function create(array $fields): Filters
    {
        return new Filters($fields);
    }

    public static function withFieldAndOperator(string $field, string $operator): Filters
    {
        return self::create([
            FilterMother::withFieldAndOperator($field, $operator)
        ]);
    }
}
