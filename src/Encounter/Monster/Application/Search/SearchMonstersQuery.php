<?php

declare(strict_types=1);

namespace Encounter\Monster\Application\Search;

use Shared\Domain\Bus\Query\Query;

final class SearchMonstersQuery implements Query
{
    public function __construct(
        private array $filters,
        private int $page = 0,
        private int $limit = 0
    ) {}

    public function filters(): array
    {
        return $this->filters;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
