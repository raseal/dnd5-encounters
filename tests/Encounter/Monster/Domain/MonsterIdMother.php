<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterId;
use Faker\Factory;

final class MonsterIdMother
{
    public static function create(string $id): MonsterId
    {
        return new MonsterId($id);
    }

    public static function random(): MonsterId
    {
        return self::create(
            Factory::create()->randomAscii()
        );
    }
}
