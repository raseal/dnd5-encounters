<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Shared\Domain\Aggregate\Collection;

final class Monsters extends Collection
{
    protected function type(): string
    {
        return Monster::class;
    }
}
