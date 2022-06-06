<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

final class Monster
{
    public function __construct(
        private MonsterId $monsterId,
        private MonsterName $monsterName,
        private SourceBook $sourceBook,
        private ChallengeRating $challengeRating,
        private MonsterHPAverage $HPAverage,
        private MonsterHPMax $HPMax
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

    public function challengeRating(): ChallengeRating
    {
        return $this->challengeRating;
    }

    public function HPAverage(): MonsterHPAverage
    {
        return $this->HPAverage;
    }

    public function HPMax(): MonsterHPMax
    {
        return $this->HPMax;
    }
}
