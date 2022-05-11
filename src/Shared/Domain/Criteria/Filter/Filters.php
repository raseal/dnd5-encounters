<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria\Filter;

use Shared\Domain\Aggregate\Collection;
use Shared\Domain\Criteria\Filter\Exception\InvalidFilter;

final class Filters extends Collection
{
    protected function type(): string
    {
        return Filter::class;
    }

    public function filters(): array
    {
        return $this->items;
    }

    public static function fromValues(array $filters, array $validFilters): self
    {
        $items = [];

        foreach ($filters as $filterField => $filter) {
            $operator = array_keys($filter)[0];
            $value = $filter[$operator];

            if (empty($validFilters[$filterField]) || !in_array($operator, $validFilters[$filterField])) {
                throw new invalidFilter($filterField, $operator);
            }

            $items[] = Filter::fromValues($filterField, $operator, $value);
        }

        return new self($items);
    }
}
