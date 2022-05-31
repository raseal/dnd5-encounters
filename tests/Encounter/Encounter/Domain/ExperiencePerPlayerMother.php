<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\ExperiencePerPlayer;
use Faker\Factory;

final class ExperiencePerPlayerMother
{
    public static function create(int $experience): ExperiencePerPlayer
    {
        return new ExperiencePerPlayer($experience);
    }

    public static function random(): ExperiencePerPlayer
    {
        return self::create(Factory::create()->numberBetween(0, 5000));
    }
}
