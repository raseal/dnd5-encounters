<?php

declare(strict_types=1);

namespace Encounter\Character\Application\GetOneCharacter;

use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;

final class GetOneCharacter
{
    public function __construct(
        private CharacterRepository $characterRepository
    ) {}

    public function __invoke(CharacterId $characterId): Character
    {
        $character = $this->characterRepository->findById($characterId);

        if (null === $character) {
            throw new CharacterDoesNotExist($characterId->value());
        }

        return $character;
    }
}
