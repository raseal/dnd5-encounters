<?php

declare(strict_types=1);

namespace Encounter\Character\Domain;

use Encounter\Character\Domain\Exception\InvalidCharacterLevel;
use Shared\Domain\ValueObject\PositiveInteger;

final class CharacterLevel extends PositiveInteger
{
    private const MAX_LEVEL = 20;

    public function __construct(int $level)
    {
        $this->ensureValidLevel($level);
        parent::__construct($level);
    }

    private function ensureValidLevel(int $level): void
    {
        if (self::MAX_LEVEL < $level) {
            throw new InvalidCharacterLevel((string) $level);
        }
    }
}
