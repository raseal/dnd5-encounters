<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Monster\Domain\Exception\InvalidMonsterSize;
use Shared\Domain\ValueObject\StringValueObject;

final class MonsterSize extends StringValueObject
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
