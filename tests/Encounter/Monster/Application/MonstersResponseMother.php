<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application;

use Encounter\Monster\Application\MonstersResponse;
use Encounter\Monster\Application\Search\MonstersViewModel;
use Encounter\Monster\Application\Search\MonsterViewModel;

final class MonstersResponseMother
{
    public static function create(array $monstersResponse): MonstersResponse
    {
        return new MonstersResponse($monstersResponse);
    }

    public static function createFromViewModel(MonstersViewModel $monstersViewModel): MonstersResponse
    {
        $monstersResponse = [];

        /** @var MonsterViewModel $monsterViewModel */
        foreach ($monstersViewModel as $monsterViewModel) {
            $monstersResponse[] = MonsterResponseMother::createFromViewModel($monsterViewModel);
        }

        return self::create($monstersResponse);
    }
}
