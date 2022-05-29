<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\InitiativeBonus;
use Faker\Factory;

final class InitiativeBonusMother
{
    public static function create(int $bonus): InitiativeBonus
    {
        return new InitiativeBonus($bonus);
    }

    public static function random(): InitiativeBonus
    {
        return self::create(
            Factory::create()->randomNumber()
        );
    }
}
