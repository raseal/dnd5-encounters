<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application;

use Encounter\Monster\Application\MonsterResponse;
use Encounter\Monster\Application\Search\MonsterViewModel;

final class MonsterResponseMother
{
    public static function create(
        string $name,
        string $size,
        string $type,
        string $tokenURL,
        string $source,
        int $page,
        int $ac,
        array $hp,
        string $speed,
        int $str,
        int $dex,
        int $con,
        int $int,
        int $wis,
        int $cha,
        ?string $savings,
        ?string $skills,
        ?string $senses,
        ?string $immunities,
        string $cr,
        ?array $actions,
        ?array $traits,
        ?array $legendaryActions
    ): MonsterResponse {
        return new MonsterResponse($name,
            $size,
            $type,
            $tokenURL,
            $source,
            $page,
            $ac,
            $hp,
            $speed,
            $str,
            $dex,
            $con,
            $int,
            $wis,
            $cha,
            $savings,
            $skills,
            $senses,
            $immunities,
            $cr,
            $actions,
            $traits,
            $legendaryActions
        );
    }

    public static function createFromViewModel(MonsterViewModel $monsterViewModel): MonsterResponse
    {
        return self::create(
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
}
