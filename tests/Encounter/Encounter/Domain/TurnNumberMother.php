<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\TurnNumber;
use Faker\Factory;

final class TurnNumberMother
{
    public static function create(int $turn): TurnNumber
    {
        return new TurnNumber($turn);
    }

    public static function random(): TurnNumber
    {
        return self::create(Factory::create()->numberBetween(1, 20));
    }
}
