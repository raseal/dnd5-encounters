<?php

declare(strict_types=1);

namespace Encounter\Monster\Application\Search;

use Shared\Domain\Aggregate\Collection;

final class MonstersViewModel extends Collection
{
    protected function type(): string
    {
        return MonsterViewModel::class;
    }
}
