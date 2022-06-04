<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class MonsterDoesNotExist extends DomainError
{
    private string $monsterId;

    public function __construct(string $id)
    {
        $this->monsterId = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Monster_does_not_exist';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The monster <%s> does not exist',
            $this->monsterId
        );
    }
}
