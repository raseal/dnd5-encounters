<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\ChallengeRating;
use Faker\Factory;

final class ChallengeRatingMother
{
    public static function create(float $cr): ChallengeRating
    {
        return new ChallengeRating($cr);
    }

    public static function random(): ChallengeRating
    {
        return self::create(
            Factory::create()->randomFloat(0, 1, 30)
        );
    }
}
