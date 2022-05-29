<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\MonsterImg;
use Faker\Factory;

final class MonsterImgMother
{
    public static function create(string $img): MonsterImg
    {
        return new MonsterImg($img);
    }

    public static function random(): MonsterImg
    {
        return self::create(Factory::create()->text(10));
    }
}
