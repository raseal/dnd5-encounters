<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Domain\Criteria\Filter\Filters;

final class Criteria
{
    public function __construct(
        private Filters $filters,
        private Offset $offset,
        private Limit $limit
    ) {}

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function offset(): Offset
    {
        return $this->offset;
    }

    public function limit(): Limit
    {
        return $this->limit;
    }
}
