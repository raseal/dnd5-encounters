<?php

declare(strict_types=1);

namespace Encounter\Character\Application\GetOneCharacter;

use Shared\Domain\Bus\Query\Query;

final class GetOneCharacterQuery implements Query
{
    public function __construct(
        private string $characterId
    ) {}

    public function characterId(): string
    {
        return $this->characterId;
    }
}
