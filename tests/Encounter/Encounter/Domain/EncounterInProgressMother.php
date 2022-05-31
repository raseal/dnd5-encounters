<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\EncounterInProgress;
use Faker\Factory;

final class EncounterInProgressMother
{
    public static function create(bool $inProgress): EncounterInProgress
    {
        return new EncounterInProgress($inProgress);
    }

    public static function random(): EncounterInProgress
    {
        return self::create(Factory::create()->boolean());
    }
}
