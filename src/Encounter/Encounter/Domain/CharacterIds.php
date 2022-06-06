<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Character\Domain\CharacterId;
use Shared\Domain\Aggregate\Collection;

final class CharacterIds extends Collection
{
    protected function type(): string
    {
        return CharacterId::class;
    }
}
