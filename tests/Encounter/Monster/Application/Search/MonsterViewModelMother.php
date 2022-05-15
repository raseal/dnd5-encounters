<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application\Search;

use Encounter\Monster\Application\Search\MonsterViewModel;
use Faker\Factory;

final class MonsterViewModelMother
{
    public static function create(
        string $name,
        string $size,
        string $type,
        string $tokenURL,
        string $source,
        int $page,
        int $ac,
        array $hp,
        string $speed,
        int $str,
        int $dex,
        int $con,
        int $int,
        int $wis,
        int $cha,
        ?string $savings,
        ?string $skills,
        ?string $senses,
        ?string $immunities,
        string $cr,
        ?array $actions,
        ?array $traits,
        ?array $legendaryActions
    ): MonsterViewModel {
        return new MonsterViewModel(
            $name,
            $size,
            $type,
            $tokenURL,
            $source,
            $page,
            $ac,
            $hp,
            $speed,
            $str,
            $dex,
            $con,
            $int,
            $wis,
            $cha,
            $savings,
            $skills,
            $senses,
            $immunities,
            $cr,
            $actions,
            $traits,
            $legendaryActions
        );
    }

    public static function random(): MonsterViewModel
    {
        $source = Factory::create()->randomAscii();
        $name = Factory::create()->text(15);

        return self::create(
            $name,
            Factory::create()->randomAscii(),
            Factory::create()->text(10),
            self::generateTokenURL($source, $name),
            $source,
            Factory::create()->randomNumber(),
            Factory::create()->randomNumber(),
            [],
            Factory::create()->text(20),
            Factory::create()->numberBetween(8, 22),
            Factory::create()->numberBetween(8, 22),
            Factory::create()->numberBetween(8, 22),
            Factory::create()->numberBetween(8, 22),
            Factory::create()->numberBetween(8, 22),
            Factory::create()->numberBetween(8, 22),
            Factory::create()->text(20),
            null,
            Factory::create()->text(10),
            null,
            Factory::create()->text(5),
            null,
            null,
            null
        );
    }

    private static function generateTokenURL(string $source, string $name): string
    {
        return $source.'/'.$name;
    }
}
