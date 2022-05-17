<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\PlayerName;
use Faker\Factory;

final class PlayerNameMother
{
    public static function create(string $name): PlayerName
    {
        return new PlayerName($name);
    }

    public static function random(): PlayerName
    {
        return self::create(Factory::create()->name());
    }
}
