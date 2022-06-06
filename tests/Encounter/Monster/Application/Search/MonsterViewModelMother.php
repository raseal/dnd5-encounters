<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application\Search;

use Encounter\Monster\Application\Search\MonsterViewModel;
use Encounter\Monster\Domain\MonsterSize;
use Faker\Factory;
use Test\Encounter\Monster\Domain\SourceBookMother;
use function sprintf;

final class MonsterViewModelMother
{
    private const VALID_SIZES = [
        't',
        's',
        'm',
        'l',
        'h',
        'g',
    ];

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
        $source = SourceBookMother::random()->value();
        $name = Factory::create()->text(15);

        return self::create(
            $name,
            Factory::create()->randomElement(self::VALID_SIZES),
            Factory::create()->text(10),
            self::generateTokenURL($source, $name),
            $source,
            Factory::create()->randomNumber(),
            Factory::create()->randomNumber(),
            [
                'average' => Factory::create()->numberBetween(1, 500),
                'formula' => self::randomHPFormula(),
            ],
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
            (string) Factory::create()->numberBetween(1, 30),
            null,
            null,
            null
        );
    }

    private static function generateTokenURL(string $source, string $name): string
    {
        return $source.'/'.$name;
    }

    private static function randomHPFormula(): string
    {
        return sprintf(
            '%sd%s+%s',
            Factory::create()->numberBetween(1, 30),
            Factory::create()->numberBetween(4, 12),
            Factory::create()->numberBetween(0, 250)
        );
    }
}
