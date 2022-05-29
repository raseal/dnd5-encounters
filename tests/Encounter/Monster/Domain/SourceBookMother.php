<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Domain;

use Encounter\Monster\Domain\SourceBook;
use Faker\Factory;

final class SourceBookMother
{
    private const BGDIA = 'Baldur\'s Gate: Descent into Avernus';
    private const DMG = 'Dungeons Master\'s Guide';
    private const FTD = 'Fizban\'s Treasury of Dragons';
    private const MM = 'Monster Manual';
    private const PHB = 'Player\'s Handbook';
    private const TCE = 'Tasha\'s Cauldron of Everything';
    private const XGE = 'Xanathar\'s Guide to Everything';

    private const VALID_TYPES = [
        'BGDIA' => self::BGDIA,
        'DMG' => self::DMG,
        'FTD' => self::FTD,
        'MM' => self::MM,
        'PHB' => self::PHB,
        'TCE' => self::TCE,
        'XGE' => self::XGE,
    ];

    public static function create(string $book): SourceBook
    {
        return new SourceBook($book);
    }

    public static function random(): SourceBook
    {
        return self::create(
            Factory::create()->randomElement(array_keys(self::VALID_TYPES))
        );
    }
}
