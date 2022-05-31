<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\EncounterId;
use Faker\Factory;

final class EncounterIdMother
{
    public static function create(string $id): EncounterId
    {
        return new EncounterId($id);
    }

    public static function random(): EncounterId
    {
        return self::create(Factory::create()->uuid());
    }
}
