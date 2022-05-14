<?php

declare(strict_types=1);

namespace Encounter\Monster\Application;

use Encounter\Monster\Application\Search\MonsterViewModel;
use Shared\Domain\Bus\Query\QueryResponse;

final class MonsterResponse implements QueryResponse
{
    public function __construct(
        private string $name,
        private string $size,
        private string $type,
        private string $tokenURL,
        private string $source,
        private int $page,
        private int $ac,
        private array $hp,
        private string $speed,
        private int $str,
        private int $dex,
        private int $con,
        private int $int,
        private int $wis,
        private int $cha,
        private ?string $savings,
        private ?string $skills,
        private ?string $senses,
        private ?string $immunities,
        private string $cr,
        private ?array $actions,
        private ?array $traits,
        private ?array $legendaryActions
    ) {}

    public static function fromMonsterViewModel(MonsterViewModel $monsterViewModel): self
    {
        return new self(
            $monsterViewModel->name(),
            $monsterViewModel->size(),
            $monsterViewModel->type(),
            $monsterViewModel->tokenURL(),
            $monsterViewModel->source(),
            $monsterViewModel->page(),
            $monsterViewModel->ac(),
            $monsterViewModel->hp(),
            $monsterViewModel->speed(),
            $monsterViewModel->str(),
            $monsterViewModel->dex(),
            $monsterViewModel->con(),
            $monsterViewModel->int(),
            $monsterViewModel->wis(),
            $monsterViewModel->cha(),
            $monsterViewModel->savings(),
            $monsterViewModel->skills(),
            $monsterViewModel->senses(),
            $monsterViewModel->immunities(),
            $monsterViewModel->cr(),
            $monsterViewModel->actions(),
            $monsterViewModel->traits(),
            $monsterViewModel->legendaryActions()
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function size(): string
    {
        return $this->size;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function tokenURL(): string
    {
        return $this->tokenURL;
    }

    public function source(): string
    {
        return $this->source;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function ac(): int
    {
        return $this->ac;
    }

    public function hp(): array
    {
        return $this->hp;
    }

    public function speed(): string
    {
        return $this->speed;
    }

    public function str(): int
    {
        return $this->str;
    }

    public function dex(): int
    {
        return $this->dex;
    }

    public function con(): int
    {
        return $this->con;
    }

    public function int(): int
    {
        return $this->int;
    }

    public function wis(): int
    {
        return $this->wis;
    }

    public function cha(): int
    {
        return $this->cha;
    }

    public function savings(): ?string
    {
        return $this->savings;
    }

    public function skills(): ?string
    {
        return $this->skills;
    }

    public function senses(): ?string
    {
        return $this->senses;
    }

    public function immunities(): ?string
    {
        return $this->immunities;
    }

    public function cr(): string
    {
        return $this->cr;
    }

    public function actions(): ?array
    {
        return $this->actions;
    }

    public function traits(): ?array
    {
        return $this->traits;
    }

    public function legendaryActions(): ?array
    {
        return $this->legendaryActions;
    }
}
