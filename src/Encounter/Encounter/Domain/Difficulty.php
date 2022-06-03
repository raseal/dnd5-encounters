<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

use Encounter\Character\Domain\Characters;
use Encounter\Encounter\Domain\Exception\InvalidEncounterDifficulty;
use Encounter\Monster\Domain\Monsters;
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

    public static function none(): self
    {
        return new self(self::NONE);
    }

    public static function fromParticipants(Characters $characters, Monsters $monsters): self
    {
        $partyThreshold = Calculator::partyThreshold($characters);
        $difficultyRating = Calculator::difficultyRating($monsters, $characters);
        $difficulty = self::calculateDifficulty($partyThreshold, $difficultyRating);

        return new self($difficulty);
    }

    private static function calculateDifficulty(array $partyThreshold, float $difficultyRating): string
    {
        $result = self::EASY;

        foreach ($partyThreshold as $difficulty => $threshold) {
            if ($threshold < $difficultyRating) {
                $result = $difficulty;
            } else {
                return $result;
            }
        }

        return self::DEADLY;
    }

    private function assertValidDifficulty(string $difficulty): void
    {
        if (false === in_array($difficulty, self::VALID_TYPES)) {
            throw new InvalidEncounterDifficulty($difficulty);
        }
    }
}
