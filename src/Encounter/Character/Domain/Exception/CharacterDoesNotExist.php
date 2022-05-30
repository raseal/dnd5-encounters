<?php

declare(strict_types=1);

namespace Encounter\Character\Domain\Exception;

use Shared\Domain\Exception\DomainError;

final class CharacterDoesNotExist extends DomainError
{
    private string $characterId;

    public function __construct(string $id)
    {
        $this->characterId = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Character_does_not_exist';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The character %s does not exist',
            $this->characterId
        );
    }
}
