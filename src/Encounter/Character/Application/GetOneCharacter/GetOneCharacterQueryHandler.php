<?php

declare(strict_types=1);

namespace Encounter\Character\Application\GetOneCharacter;

use Encounter\Character\Application\CharacterResponse;
use Encounter\Character\Domain\CharacterId;
use Shared\Domain\Bus\Query\QueryHandler;

final class GetOneCharacterQueryHandler implements QueryHandler
{
    public function __construct(
        private GetOneCharacter $getOneCharacter
    ) {}

    public function __invoke(GetOneCharacterQuery $query): CharacterResponse
    {
        $character = $this->getOneCharacter->__invoke(
            new CharacterId($query->characterId())
        );

        return CharacterResponse::fromCharacter($character);
    }
}
