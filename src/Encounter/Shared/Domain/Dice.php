<?php

declare(strict_types=1);

namespace Encounter\Shared\Domain;

use Shared\Domain\ValueObject\PositiveInteger;
use function mt_rand;

final class Dice
{
    private const MIN_SIDES = 1;

    public function __construct(
        private PositiveInteger $sides
    ) {}

    public function roll($times = 1, $maxRoll = false): PositiveInteger
    {
        $total = 0;

        for ($i = 0; $i < $times; $i++) {
            $total += $maxRoll ?
                $this->sides->value() :
                mt_rand(self::MIN_SIDES, $this->sides->value());
        }

        return new PositiveInteger($total);
    }
}
