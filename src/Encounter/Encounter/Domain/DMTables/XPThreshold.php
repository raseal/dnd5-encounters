<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain\DMTables;

use Encounter\Character\Domain\CharacterLevel;
use Encounter\Character\Domain\Exception\InvalidCharacterLevel;
use Encounter\Encounter\Domain\Difficulty;

final class XPThreshold
{
    // Annoying dnd5 tables!
    private const XP_THRESHOLD = [
        1 => [Difficulty::EASY => 25, Difficulty::MEDIUM => 50, Difficulty::HARD=> 75, Difficulty::DEADLY=> 100],
        2 => [Difficulty::EASY => 50, Difficulty::MEDIUM => 100, Difficulty::HARD => 150, Difficulty::DEADLY => 200],
        3 => [Difficulty::EASY => 75, Difficulty::MEDIUM => 150, Difficulty::HARD => 225, Difficulty::DEADLY => 400],
        4 => [Difficulty::EASY => 125, Difficulty::MEDIUM => 250, Difficulty::HARD => 375, Difficulty::DEADLY => 500],
        5 => [Difficulty::EASY => 250, Difficulty::MEDIUM => 500, Difficulty::HARD => 750, Difficulty::DEADLY => 1100],
        6 => [Difficulty::EASY => 300, Difficulty::MEDIUM => 600, Difficulty::HARD => 900, Difficulty::DEADLY => 1400],
        7 => [Difficulty::EASY => 350, Difficulty::MEDIUM => 750, Difficulty::HARD => 1100, Difficulty::DEADLY => 1700],
        8 => [Difficulty::EASY => 450, Difficulty::MEDIUM => 900, Difficulty::HARD => 1400, Difficulty::DEADLY => 2100],
        9 => [Difficulty::EASY => 550, Difficulty::MEDIUM => 1100, Difficulty::HARD => 1600, Difficulty::DEADLY => 2400],
        10 => [Difficulty::EASY => 600, Difficulty::MEDIUM => 1200, Difficulty::HARD => 1900, Difficulty::DEADLY => 2800],
        11 => [Difficulty::EASY => 800, Difficulty::MEDIUM => 1600, Difficulty::HARD => 2400, Difficulty::DEADLY => 3600],
        12 => [Difficulty::EASY => 1000, Difficulty::MEDIUM => 2000, Difficulty::HARD => 3000, Difficulty::DEADLY => 4500],
        13 => [Difficulty::EASY => 1100, Difficulty::MEDIUM => 2200, Difficulty::HARD => 3400, Difficulty::DEADLY => 5100],
        14 => [Difficulty::EASY => 1250, Difficulty::MEDIUM => 2500, Difficulty::HARD => 3800, Difficulty::DEADLY => 5700],
        15 => [Difficulty::EASY => 1400, Difficulty::MEDIUM => 2800, Difficulty::HARD => 4300, Difficulty::DEADLY => 6400],
        16 => [Difficulty::EASY => 1600, Difficulty::MEDIUM => 3200, Difficulty::HARD => 4800, Difficulty::DEADLY => 7200],
        17 => [Difficulty::EASY => 2000, Difficulty::MEDIUM => 3900, Difficulty::HARD => 5900, Difficulty::DEADLY => 8800],
        18 => [Difficulty::EASY => 2100, Difficulty::MEDIUM => 4200, Difficulty::HARD => 6300, Difficulty::DEADLY => 9500],
        19 => [Difficulty::EASY => 2400, Difficulty::MEDIUM => 4900, Difficulty::HARD => 7300, Difficulty::DEADLY => 10900],
        20 => [Difficulty::EASY => 2800, Difficulty::MEDIUM => 5700, Difficulty::HARD => 8500, Difficulty::DEADLY => 12700],
    ];

    public static function get(CharacterLevel $level): array
    {
        return self::XP_THRESHOLD[$level->value()] ?? throw new InvalidCharacterLevel((string) $level->value());
    }
}
