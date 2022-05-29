<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

interface MonsterRepository
{
    public function findbyId(MonsterId $monsterId): ?Monster;

    public function save(Monster $monster): void;
}
