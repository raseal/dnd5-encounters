<?php

declare(strict_types=1);

namespace Encounter\Monster\Application;

use Encounter\Monster\Application\Search\MonstersViewModel;
use Shared\Domain\Criteria\Criteria;

interface MonsterReadModel
{
    public function search(Criteria $criteria): MonstersViewModel;
}
