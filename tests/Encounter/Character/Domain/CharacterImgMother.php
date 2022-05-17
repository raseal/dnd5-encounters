<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Domain;

use Encounter\Character\Domain\CharacterImg;
use Faker\Factory;

final class CharacterImgMother
{
    public static function create(string $img): CharacterImg
    {
        return new CharacterImg($img);
    }

    public static function random(): CharacterImg
    {
        return self::create(Factory::create()->text(10));
    }
}
