<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use function md5;
use function sprintf;

final class Monster
{
    private MonsterId $monsterId;

    public function __construct(
        ?MonsterId $monsterId,
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
    ) {
        if (null === $monsterId) {
           $this->generateMonsterId();
        }
    }

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

    public function HPAverage(): MonsterHPAverage
    {
        return $this->HPAverage;
    }

    public function HPMax(): MonsterHPMax
    {
        return $this->HPMax;
    }

    public function armorClass(): MonsterArmorClass
    {
        return $this->armorClass;
    }

    private function generateMonsterId(): void
    {
        $hash = md5(
            sprintf(
                '%s%s%s',
                $this->monsterName->value(),
                $this->sourceBook->value(),
                $this->page->value()
            )
        );

        $this->monsterId = new MonsterId($hash);
    }
}
