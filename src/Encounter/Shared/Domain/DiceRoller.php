<?php

declare(strict_types=1);

namespace Encounter\Shared\Domain;

use Shared\Domain\ValueObject\PositiveInteger;
use function explode;

final class DiceRoller
{
    public static function rollFormula(string $formula, bool $maxRolls = false): PositiveInteger
    {
        $parts = explode('+', $formula);
        $constantToAdd = (int) $parts[1];
        $toRoll = $parts[0];

        $dices = explode('d', $toRoll);
        $sides = new PositiveInteger((int) $dices[1]);
        $times = (int) $dices[0];

        $dice = new Dice($sides);
        $total = $dice->roll($times, $maxRolls);

        return new PositiveInteger($total->value() + $constantToAdd);
    }
}
