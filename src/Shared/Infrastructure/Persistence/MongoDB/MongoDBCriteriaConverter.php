<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\MongoDB;

use MongoDB\BSON\Regex;
use Shared\Domain\Criteria\Filter\Exception\InvalidOperator;
use Shared\Domain\Criteria\Filter\Filter;
use Shared\Domain\Criteria\Filter\FilterOperator;

final class MongoDBCriteriaConverter
{
    public static function transform(Filter $filter): array
    {
        return match ($filter->operator()->value()) {
            FilterOperator::EQ => self::eq($filter),
            FilterOperator::LIKE => self::like($filter),
            default => throw new InvalidOperator($filter->operator()->value())
        };
    }

    private static function eq(Filter $filter): array
    {
        return [
            $filter->field()->value() => $filter->value()->value()
        ];
    }

    private static function like(Filter $filter): array
    {
        return [
            $filter->field()->value() => new Regex($filter->value()->value(), 'i')
        ];
    }
}
