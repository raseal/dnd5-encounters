<?php

declare(strict_types=1);

namespace Encounter\Character\Application;

use Encounter\Character\Domain\Character;
use Shared\Domain\Bus\Query\QueryResponse;

final class CharacterResponse implements QueryResponse
{
    public function __construct(
        private string $characterId,
        private string $characterName,
        private string $playerName,
        private string $campaignId,
        private int $characterLevel,
        private int $characterArmorClass,
        private int $characterHP,
        private int $characterSpeed,
        private string $characterImg
    ) {}

    public static function fromCharacter(Character $character): self
    {
        return new self(
            $character->characterId()->value(),
            $character->characterName()->value(),
            $character->playerName()->value(),
            $character->campaignId()->value(),
            $character->characterLevel()->value(),
            $character->characterArmorClass()->value(),
            $character->characterHP()->value(),
            $character->characterSpeed()->value(),
            $character->characterImg()->value()
        );
    }

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

    public function characterLevel(): int
    {
        return $this->characterLevel;
    }

    public function characterArmorClass(): int
    {
        return $this->characterArmorClass;
    }

    public function characterHP(): int
    {
        return $this->characterHP;
    }

    public function characterSpeed(): int
    {
        return $this->characterSpeed;
    }

    public function characterImg(): string
    {
        return $this->characterImg;
    }
}
