<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\RoundNumber;
use Faker\Factory;

final class RoundNumberMother
{
    public static function create(int $round): RoundNumber
    {
        return new RoundNumber($round);
    }

    public static function random(): RoundNumber
    {
        return self::create(Factory::create()->numberBetween(0, 15));
    }
}
