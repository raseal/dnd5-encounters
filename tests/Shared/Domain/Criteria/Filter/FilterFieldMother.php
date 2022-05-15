<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria\Filter;

use Shared\Domain\Criteria\Filter\FilterField;

final class FilterFieldMother
{
    public static function create(string $field): FilterField
    {
        return new FilterField($field);
    }
}
