<?php

declare(strict_types=1);

namespace Encounter\Character\Domain;

interface CharacterRepository
{
    public function save(Character $character): void;

    public function findById(CharacterId $characterId): ?Character;
}
