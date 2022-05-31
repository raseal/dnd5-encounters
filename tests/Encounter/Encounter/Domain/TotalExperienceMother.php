<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\TotalExperience;
use Faker\Factory;

final class TotalExperienceMother
{
    public static function create(int $experience): TotalExperience
    {
        return new TotalExperience($experience);
    }

    public static function random(): TotalExperience
    {
        return self::create(Factory::create()->numberBetween(0, 50000));
    }
}
