<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Application\GetOneCharacter;

use Encounter\Character\Application\GetOneCharacter\GetOneCharacterQuery;
use Faker\Factory;

final class GetOneCharacterQueryMother
{
    public static function create(string $characterId): GetOneCharacterQuery
    {
        return new GetOneCharacterQuery($characterId);
    }

    public static function random(): GetOneCharacterQuery
    {
        return self::create(
            Factory::create()->uuid()
        );
    }
}
