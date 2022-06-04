<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Monster\Domain\Exception\InvalidMonsterSize;
use Shared\Domain\ValueObject\StringValueObject;
use function strtolower;

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

    private const VALID_ABBREVIATIONS = [
        't' => self::TINY,
        's' => self::SMALL,
        'm' => self::MEDIUM,
        'l' => self::LARGE,
        'h' => self::HUGE,
        'g' => self::GARGANTUAN,
    ];

    public function __construct(string $size)
    {
        $this->assertValidSize($size);
        parent::__construct($size);
    }

    public static function fromAbbreviation(string $abbreviation): self
    {
        $index = strtolower($abbreviation);

        if (!isset(self::VALID_ABBREVIATIONS[$index])) {
            throw new InvalidMonsterSize($abbreviation);
        }

        return new self(
            self::VALID_ABBREVIATIONS[$index]
        );
    }

    private function assertValidSize(string $size): void
    {
        if (!isset(self::VALID_TYPES[strtolower($size)])) {
            throw new InvalidMonsterSize($size);
        }
    }
}
