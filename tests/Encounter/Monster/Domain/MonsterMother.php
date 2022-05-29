<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\InitiativeBonus;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterArmorClass;
use Encounter\Monster\Domain\MonsterHPAverage;
use Encounter\Monster\Domain\MonsterHPMax;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterImg;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\MonsterSize;
use Encounter\Monster\Domain\Page;
use Encounter\Monster\Domain\SourceBook;

final class MonsterMother
{
    public static function create(
        MonsterId $monsterId,
        MonsterName $monsterName,
        SourceBook $sourceBook,
        Page $page,
        MonsterSize $monsterSize,
        ChallengeRating $challengeRating,
        MonsterImg $monsterImg,
        InitiativeBonus $initiativeBonus,
        MonsterHPAverage $HPAverage,
        MonsterHPMax $HPMax,
        MonsterArmorClass $armorClass
    ): Monster {
        return new Monster(
            $monsterId,
            $monsterName,
            $sourceBook,
            $page,
            $monsterSize,
            $challengeRating,
            $monsterImg,
            $initiativeBonus,
            $HPAverage,
            $HPMax,
            $armorClass
        );
    }

    public static function random(): Monster
    {
        return self::create(
            MonsterIdMother::random(),
            MonsterNameMother::random(),
            SourceBookMother::random(),
            PageMother::random(),
            MonsterSizeMother::random(),
            ChallengeRatingMother::random(),
            MonsterImgMother::random(),
            InitiativeBonusMother::random(),
            MonsterHPAverageMother::random(),
            MonsterHPMaxMother::random(),
            MonsterArmorClassMother::random()
        );
    }
}
