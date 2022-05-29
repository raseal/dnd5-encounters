<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\Page;
use Faker\Factory;

final class PageMother
{
    public static function create(int $page): Page
    {
        return new Page($page);
    }

    public static function random(): Page
    {
        return self::create(
            Factory::create()->randomNumber()
        );
    }
}
