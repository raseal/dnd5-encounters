<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidChallengeRating extends DomainError
{
    private string $challengeRating;

    public function __construct(string $challengeRating)
    {
        $this->challengeRating = $challengeRating;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Challenge_rating_out_of_range';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The challenge rating <%s> is not valid',
            $this->challengeRating
        );
    }
}
