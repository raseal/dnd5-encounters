<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Monster\Domain\Monsters;
use Shared\Domain\ValueObject\PositiveInteger;

final class TotalExperience extends PositiveInteger
{
    public static function fromMonsters(Monsters $monsters): self
    {
        return new self(
            Calculator::monstersXP($monsters)
        );
    }
}
