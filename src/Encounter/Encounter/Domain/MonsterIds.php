<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Monster\Domain\MonsterId;
use Shared\Domain\Aggregate\Collection;

final class MonsterIds extends Collection
{
    protected function type(): string
    {
        return MonsterId::class;
    }
}
