<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterSize;
use Faker\Factory;

final class MonsterSizeMother
{
    private const TINY = 'Tiny';
    private const SMALL = 'Small';
    private const MEDIUM = 'Medium';
    private const LARGE = 'Large';
    private const HUGE = 'Huge';
    private const GARGANTUAN = 'Gargantuan';

    private const VALID_TYPES = [
        'tiny' => self::TINY,
        'small' => self::SMALL,
        'medium' => self::MEDIUM,
        'large' => self::LARGE,
        'huge' => self::HUGE,
        'gargantuan' => self::GARGANTUAN,
    ];

    public static function create(string $size): MonsterSize
    {
        return new MonsterSize($size);
    }

    public static function random(): MonsterSize
    {
        return self::create(
            Factory::create()->randomElement(array_keys(self::VALID_TYPES))
        );
    }
}
