<?php

declare(strict_types=1);

namespace Encounter\Encounter\Domain;

interface EncounterRepository
{
    public function findById(EncounterId $encounterId): ?Encounter;

    public function save(Encounter $encounter): void;
}
