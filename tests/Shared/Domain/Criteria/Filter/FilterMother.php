<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria\Filter;

use Shared\Domain\Criteria\Filter\Filter;
use Shared\Domain\Criteria\Filter\FilterField;
use Shared\Domain\Criteria\Filter\FilterOperator;
use Shared\Domain\Criteria\Filter\FilterValue;

final class FilterMother
{
    public static function create(
        FilterField $field,
        FilterOperator $operator,
        FilterValue $value
    ): Filter {
        return new Filter($field, $operator, $value);
    }

    public static function withFieldAndOperator(string $field, string $operator): Filter
    {
        return self::create(
            FilterFieldMother::create($field),
            FilterOperatorMother::create($operator),
            FilterValueMother::random()
        );
    }
}
