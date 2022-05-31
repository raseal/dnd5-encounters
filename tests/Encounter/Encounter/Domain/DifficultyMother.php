<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\Difficulty;
use Faker\Factory;

final class DifficultyMother
{
    public static function create(string $difficulty): Difficulty
    {
        return new Difficulty($difficulty);
    }

    public static function random(): Difficulty
    {
        return self::create(
            Factory::create()->randomElement(Difficulty::VALID_TYPES)
        );
    }
}
