<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterHPAverage;
use Encounter\Monster\Domain\MonsterHPMax;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\SourceBook;

final class MonsterMother
{
    public static function create(
        MonsterId $monsterId,
        MonsterName $monsterName,
        SourceBook $sourceBook,
        ChallengeRating $challengeRating,
        MonsterHPAverage $HPAverage,
        MonsterHPMax $HPMax
    ): Monster {
        return new Monster(
            $monsterId,
            $monsterName,
            $sourceBook,
            $challengeRating,
            $HPAverage,
            $HPMax
        );
    }

    public static function random(): Monster
    {
        return self::create(
            MonsterIdMother::random(),
            MonsterNameMother::random(),
            SourceBookMother::random(),
            ChallengeRatingMother::random(),
            MonsterHPAverageMother::random(),
            MonsterHPMaxMother::random()
        );
    }
}
