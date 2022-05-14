<?php

declare(strict_types=1);

namespace Encounter\Monster\Application;

use Shared\Domain\Aggregate\Collection;
use Shared\Domain\Bus\Query\QueryResponse;

final class MonstersResponse extends Collection implements QueryResponse
{
    protected function type(): string
    {
        return MonsterResponse::class;
    }
}
