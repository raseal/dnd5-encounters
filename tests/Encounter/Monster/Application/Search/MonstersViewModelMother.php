<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application\Search;

use Encounter\Monster\Application\Search\MonstersViewModel;
use Faker\Factory;

final class MonstersViewModelMother
{
    public static function create(array $monstersViewModel): MonstersViewModel
    {
        return new MonstersViewModel($monstersViewModel);
    }

    public static function random(): MonstersViewModel
    {
        $monstersViewModel = [];
        $numberMonsters = Factory::create()->numberBetween(1, 10);

        for($i = 0; $i < $numberMonsters; $i++) {
            $monstersViewModel[] = MonsterViewModelMother::random();
        }

        return self::create($monstersViewModel);
    }
}
