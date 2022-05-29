<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidMonsterSize extends DomainError
{
    private string $monsterSize;

    public function __construct(string $size)
    {
        $this->monsterSize = $size;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Invalid_monster_size';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The monster size %s is not valid',
            $this->monsterSize
        );
    }
}
