<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

final class Monster
{
    public function __construct(
        private MonsterId $monsterId,
        private MonsterName $monsterName,
        private SourceBook $sourceBook,
        private Page $page,
        private MonsterSize $monsterSize,
        private ChallengeRating $challengeRating,
        private MonsterImg $monsterImg,
        private InitiativeBonus $initiativeBonus,
        private MonsterHPAverage $HPAverage,
        private MonsterHPMax $HPMax,
        private MonsterArmorClass $armorClass
    ) {}

    public function monsterId(): MonsterId
    {
        return $this->monsterId;
    }

    public function monsterName(): MonsterName
    {
        return $this->monsterName;
    }

    public function sourceBook(): SourceBook
    {
        return $this->sourceBook;
    }

    public function page(): Page
    {
        return $this->page;
    }

    public function monsterSize(): MonsterSize
    {
        return $this->monsterSize;
    }

    public function challengeRating(): ChallengeRating
    {
        return $this->challengeRating;
    }

    public function monsterImg(): MonsterImg
    {
        return $this->monsterImg;
    }

    public function initiativeBonus(): InitiativeBonus
    {
        return $this->initiativeBonus;
    }

    public function hPAverage(): MonsterHPAverage
    {
        return $this->HPAverage;
    }

    public function hPMax(): MonsterHPMax
    {
        return $this->HPMax;
    }

    public function armorClass(): MonsterArmorClass
    {
        return $this->armorClass;
    }
}
