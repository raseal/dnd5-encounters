<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class EncounterAlreadyExists extends DomainError
{
    private string $encounterId;

    public function __construct(string $id)
    {
        $this->encounterId = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Encounter_already_exists';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The encounter %s already exists',
            $this->encounterId
        );
    }
}
