<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Monster\Domain\Exception\InvalidChallengeRating;
use Shared\Domain\ValueObject\FloatValueObject;

final class ChallengeRating extends FloatValueObject
{
    private const MAX_CHALLENGE_RATING = 30;

    public function __construct(float $challengeRating)
    {
        $this->ensureValidChallengeRating($challengeRating);
        parent::__construct($challengeRating);
    }

    private function ensureValidChallengeRating(float $challengeRating): void
    {
        if (self::MAX_CHALLENGE_RATING < $challengeRating) {
            throw new InvalidChallengeRating((string) $challengeRating);
        }
    }
}
