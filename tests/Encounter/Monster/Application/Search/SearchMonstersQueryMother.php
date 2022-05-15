<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application\Search;

use Encounter\Monster\Application\Search\SearchMonstersQuery;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter\Filter;

final class SearchMonstersQueryMother
{
    public static function create(array $filters, int $page, int $limit): SearchMonstersQuery
    {
        return new SearchMonstersQuery($filters, $page, $limit);
    }

    public static function fromCriteria(Criteria $criteria): SearchMonstersQuery
    {
        $rawFilters = [];
        $criteriaFilters = $criteria->filters();
        $limit = $criteria->limit()->value();
        $page = 1 + ($criteria->offset()->value() / $limit);

        /** @var Filter $criteriaFilter */
        foreach($criteriaFilters as $criteriaFilter) {
            $rawFilters[$criteriaFilter->field()->value()] = [
                $criteriaFilter->operator()->value() => $criteriaFilter->value()->value()
            ];
        }

        return self::create($rawFilters, (int) $page, $limit);
    }
}
