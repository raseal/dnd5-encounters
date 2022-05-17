<?php

declare(strict_types=1);

namespace Encounter\Character\Domain\Exception;

use Shared\Domain\Exception\DomainError;

final class CharacterAlreadyExists extends DomainError
{
    private string $characterId;

    public function __construct(string $id)
    {
        $this->characterId = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Character_already_exists';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The character %s already exists',
            $this->characterId
        );
    }
}
