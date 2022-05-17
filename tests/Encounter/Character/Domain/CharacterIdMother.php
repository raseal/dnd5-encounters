<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterId;
use Faker\Factory;

final class CharacterIdMother
{
    public static function create(string $uuid): CharacterId
    {
        return new CharacterId($uuid);
    }

    public static function random(): CharacterId
    {
        return self::create(Factory::create()->uuid());
    }
}
