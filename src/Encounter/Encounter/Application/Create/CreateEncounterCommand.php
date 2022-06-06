<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Shared\Domain\Bus\Command\Command;

final class CreateEncounterCommand implements Command
{
    public function __construct(
        private string $encounterId,
        private string $campaignId,
        private bool $inProgress,
        private array $monsterIds,
        private array $playerIds,
        private string $encounterName
    ) {}

    public function encounterId(): string
    {
        return $this->encounterId;
    }

    public function campaignId(): string
    {
        return $this->campaignId;
    }

    public function inProgress(): bool
    {
        return $this->inProgress;
    }

    public function monsterIds(): array
    {
        return $this->monsterIds;
    }

    public function playerIds(): array
    {
        return $this->playerIds;
    }

    public function encounterName(): string
    {
        return $this->encounterName;
    }
}
