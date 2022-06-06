<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\SourceBook;

final class MonsterIdMother
{
    public static function create(
        MonsterName $monsterName,
        SourceBook $sourceBook
    ): MonsterId {
        return new MonsterId($monsterName, $sourceBook);
    }

    public static function random(): MonsterId
    {
        return self::create(
            MonsterNameMother::random(),
            SourceBookMother::random()
        );
    }
}
