<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\Characters;
use Encounter\Encounter\Domain\DMTables\CRThreshold;
use Encounter\Encounter\Domain\DMTables\PartyMultiplier;
use Encounter\Encounter\Domain\DMTables\XPThreshold;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\Monsters;

final class Calculator
{
    public static function partyThreshold(Characters $characters): array
    {
        $partyThreshold = [
            Difficulty::EASY => 0,
            Difficulty::MEDIUM => 0,
            Difficulty::HARD => 0,
            Difficulty::DEADLY => 0,
        ];

        /** @var Character $character */
        foreach ($characters as $character) {
            $threshold = XPThreshold::get($character->characterLevel());

            $partyThreshold[Difficulty::EASY] += $threshold[Difficulty::EASY];
            $partyThreshold[Difficulty::MEDIUM] += $threshold[Difficulty::MEDIUM];
            $partyThreshold[Difficulty::HARD] += $threshold[Difficulty::HARD];
            $partyThreshold[Difficulty::DEADLY] += $threshold[Difficulty::DEADLY];
        }

        return $partyThreshold;
    }

    public static function monstersXP(Monsters $monsters): int
    {
        $monstersXP = 0;

        /** @var Monster $monster */
        foreach ($monsters as $monster) {
            $monstersXP += CRThreshold::get($monster->challengeRating());
        }

        return $monstersXP;
    }

    public static function difficultyRating(Monsters $monsters, Characters $characters): float
    {
        $monstersXP = self::monstersXP($monsters);
        $multiplier = self::encounterMultiplier($monsters, $characters);

        return $monstersXP * $multiplier;
    }

    private static function encounterMultiplier(Monsters $monsters, Characters $characters): float
    {
        $multiplier = PartyMultiplier::get($characters->count());
        $monstersAmount = $monsters->count();

        if ($monstersAmount <= 1) {
            return $multiplier[0];
        }

        if ($monstersAmount == 2) {
            return $multiplier[1];
        }

        if ($monstersAmount <= 6) {
            return $multiplier[2];
        }

        if ($monstersAmount <= 10) {
            return $multiplier[3];
        }

        if ($monstersAmount <= 14) {
            return $multiplier[4];
        }

        return $multiplier[5];
    }
}
