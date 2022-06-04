<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Shared\Domain\ValueObject\IntegerValueObject;

final class InitiativeBonus extends IntegerValueObject
{
    public static function fromDexterity(int $dexterity): self
    {
        $bonus = ($dexterity - 10)/2;

        return new self(
            (int) floor($bonus)
        );
    }
}
