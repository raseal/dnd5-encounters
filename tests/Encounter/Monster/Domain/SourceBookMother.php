<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\SourceBook;
use Faker\Factory;

final class SourceBookMother
{
    public static function create(string $book): SourceBook
    {
        return new SourceBook($book);
    }

    public static function random(): SourceBook
    {
        return self::create(
            Factory::create()->randomKey(SourceBook::VALID_TYPES)
        );
    }
}
