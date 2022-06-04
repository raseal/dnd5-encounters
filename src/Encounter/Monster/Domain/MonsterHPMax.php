<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Shared\Domain\DiceRoller;
use Shared\Domain\ValueObject\PositiveInteger;

final class MonsterHPMax extends PositiveInteger
{
    public static function fromFormula(string $formula): self
    {
        return new self(
            DiceRoller::rollFormula($formula, true)->value()
        );
    }
}
