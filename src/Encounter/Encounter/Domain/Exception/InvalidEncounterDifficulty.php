<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidEncounterDifficulty extends DomainError
{
    private string $difficulty;

    public function __construct(string $difficulty)
    {
        $this->difficulty = $difficulty;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Difficulty_value_is_not_valid';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Computed difficulty %s is not valid',
            $this->difficulty
        );
    }
}
