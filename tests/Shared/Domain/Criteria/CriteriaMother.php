<?php

declare(strict_types=1);

namespace Test\Shared\Domain\Criteria;

use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter\Filters;
use Shared\Domain\Criteria\Limit;
use Shared\Domain\Criteria\Offset;
use Test\Shared\Domain\Criteria\Filter\FiltersMother;

final class CriteriaMother
{
    public static function create(
        Filters $filters,
        Offset $offset,
        Limit $limit
    ): Criteria {
        return new Criteria($filters, $offset, $limit);
    }

    public static function withFieldAndOperator(string $field, string $operator): Criteria
    {
        $limit = LimitMother::random();

        return self::create(
            FiltersMother::withFieldAndOperator($field, $operator),
            OffsetMother::randomFromLimit($limit->value()),
            $limit
        );
    }
}
