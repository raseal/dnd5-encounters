<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain\DMTables;

final class PartyMultiplier
{
    private const MULTIPLIERS = [
        'smallParty' => [1.5, 2, 2.5, 3, 4, 5],
        'normalParty' => [1, 1.5, 2, 2.5, 3, 4],
        'largeParty' => [0.5, 1, 1.5, 2, 2.5, 3],
    ];

    public static function get(int $partySize): array
    {
        if ($partySize < 3) {
            return self::MULTIPLIERS['smallParty'];
        }

        if ($partySize > 5) {
            return self::MULTIPLIERS['largeParty'];
        }

        return self::MULTIPLIERS['normalParty'];
    }
}
