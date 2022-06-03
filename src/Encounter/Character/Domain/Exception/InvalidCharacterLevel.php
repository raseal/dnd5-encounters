<?php

declare(strict_types=1);

namespace Encounter\Character\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidCharacterLevel extends DomainError
{
    private string $level;

    public function __construct(string $level)
    {
        $this->level = $level;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Character_level_out_of_range';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The character level <%s> is not valid',
            $this->level
        );
    }
}
