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
        private array $monsters,
        private array $players,
        private string $encounterName,
        private int $round,
        private int $turn
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

    public function monsters(): array
    {
        return $this->monsters;
    }

    public function players(): array
    {
        return $this->players;
    }

    public function encounterName(): string
    {
        return $this->encounterName;
    }

    public function round(): int
    {
        return $this->round;
    }

    public function turn(): int
    {
        return $this->turn;
    }
}
