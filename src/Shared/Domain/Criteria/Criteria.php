<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Domain\Criteria\Filter\Filters;

final class Criteria
{
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 5;

    public function __construct(
        private Filters $filters,
        private int $offset = self::DEFAULT_OFFSET,
        private int $limit = self::DEFAULT_LIMIT
    ) {}

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
