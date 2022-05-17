<?php

declare(strict_types=1);

namespace Encounter\Character\Application\Create;

use Shared\Domain\Bus\Command\Command;

final class CreateCharacterCommand implements Command
{
    public function __construct(
        private string $characterId,
        private string $characterName,
        private string $playerName,
        private string $campaignId,
        private int $level,
        private int $ac,
        private int $hp,
        private int $speed,
        private string $img
    ) {}

    public function characterId(): string
    {
        return $this->characterId;
    }

    public function characterName(): string
    {
        return $this->characterName;
    }

    public function playerName(): string
    {
        return $this->playerName;
    }

    public function campaignId(): string
    {
        return $this->campaignId;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function ac(): int
    {
        return $this->ac;
    }

    public function hp(): int
    {
        return $this->hp;
    }

    public function speed(): int
    {
        return $this->speed;
    }

    public function img(): string
    {
        return $this->img;
    }
}
