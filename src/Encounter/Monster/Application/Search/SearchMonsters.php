<?php

declare(strict_types=1);

namespace Encounter\Monster\Application\Search;

use Encounter\Monster\Application\MonsterReadModel;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter\Filters;
use Shared\Domain\Criteria\Limit;
use Shared\Domain\Criteria\Offset;

final class SearchMonsters
{
    public function __construct(
        private MonsterReadModel $monsterReadModel
    ) {}

    public function __invoke(Filters $filters, Offset $offset, Limit $limit): MonstersViewModel
    {
        $criteria = new Criteria($filters, $offset, $limit);

        return $this->monsterReadModel->search($criteria);
    }
}
