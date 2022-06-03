<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain\DMTables;

use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\Exception\InvalidChallengeRating;

final class CRThreshold
{
    // Annoying dnd5 tables :(
    private const CR_THRESHOLD = [
        '1/8' => 25,
        '1/4' => 50,
        '1/2' => 100,
        '1' => 200,
        '2' => 450,
        '3' => 700,
        '4' => 1100,
        '5' => 1800,
        '6' => 2300,
        '7' => 2900,
        '8' => 3900,
        '9' => 5000,
        '10' => 5900,
        '11' => 7200,
        '12' => 8400,
        '13' => 10000,
        '14' => 11500,
        '15' => 13000,
        '16' => 15000,
        '17' => 18000,
        '18' => 20000,
        '19' => 22000,
        '20' => 25000,
        '21' => 33000,
        '22' => 41000,
        '23' => 50000,
        '24' => 62000,
        '25' => 75000,
        '26' => 90000,
        '27' => 105000,
        '28' => 120000,
        '29' => 135000,
        '30' => 155000,
    ];

    public static function get(ChallengeRating $cr): int
    {
        $numericCR = $cr->value();

        return match ($numericCR) {
            0.125 => self::CR_THRESHOLD['1/8'],
            0.25 => self::CR_THRESHOLD['1/4'],
            0.5 => self::CR_THRESHOLD['1/2'],
            default => self::CR_THRESHOLD[$numericCR] ?? throw new InvalidChallengeRating((string) $numericCR)
        };
    }
}
