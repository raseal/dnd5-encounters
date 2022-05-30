<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Encounter\Domain\Exception\InvalidEncounterDifficulty;
use Shared\Domain\ValueObject\StringValueObject;

final class Difficulty extends StringValueObject
{
    public const NONE = 'None';
    public const EASY = 'Easy';
    public const MEDIUM = 'Medium';
    public const HARD = 'Hard';
    public const DEADLY = 'Deadly';

    public const VALID_TYPES = [
        self::NONE,
        self::EASY,
        self::MEDIUM,
        self::HARD,
        self::DEADLY,
    ];

    public function __construct(string $difficulty)
    {
        $this->assertValidDifficulty($difficulty);
        parent::__construct($difficulty);
    }

    public static function fromNone(): self
    {
        return new self(self::NONE);
    }

    private function assertValidDifficulty(string $difficulty): void
    {
        if (false === in_array($difficulty, self::VALID_TYPES)) {
            throw new InvalidEncounterDifficulty($difficulty);
        }
    }
}
