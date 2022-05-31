<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Monster\Domain\Exception\InvalidMonsterSize;
use Shared\Domain\ValueObject\StringValueObject;

final class MonsterSize extends StringValueObject
{
    public const TINY = 'Tiny';
    public const SMALL = 'Small';
    public const MEDIUM = 'Medium';
    public const LARGE = 'Large';
    public const HUGE = 'Huge';
    public const GARGANTUAN = 'Gargantuan';

    public const VALID_TYPES = [
        'tiny' => self::TINY,
        'small' => self::SMALL,
        'medium' => self::MEDIUM,
        'large' => self::LARGE,
        'huge' => self::HUGE,
        'gargantuan' => self::GARGANTUAN,
    ];

    public function __construct(string $size)
    {
        $this->assertValidSize($size);
        parent::__construct($size);
    }

    private function assertValidSize(string $size): void
    {
        if (!isset(self::VALID_TYPES[strtolower($size)])) {
            throw new InvalidMonsterSize($size);
        }
    }
}
