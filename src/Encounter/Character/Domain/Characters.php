<?php

declare(strict_types=1);

namespace Encounter\Character\Domain;

use Shared\Domain\Aggregate\Collection;

final class Characters extends Collection
{
    protected function type(): string
    {
        return Character::class;
    }
}
