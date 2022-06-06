<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class InvalidMonsterIdStructure extends DomainError
{
    private string $dataAsString;

    public function __construct(string $data)
    {
        $this->dataAsString = $data;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Invalid_monsterId_structure';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The monsterId structure <%s> is not valid',
            $this->dataAsString
        );
    }
}
