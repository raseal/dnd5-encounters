<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Monster\Domain\Exception\InvalidSourceBook;
use Shared\Domain\ValueObject\StringValueObject;
use function strtoupper;

final class SourceBook extends StringValueObject
{
    public const BGDIA = 'Baldur\'s Gate: Descent into Avernus';
    public const DMG = 'Dungeons Master\'s Guide';
    public const FTD = 'Fizban\'s Treasury of Dragons';
    public const MM = 'Monster Manual';
    public const PHB = 'Player\'s Handbook';
    public const TCE = 'Tasha\'s Cauldron of Everything';
    public const XGE = 'Xanathar\'s Guide to Everything';

    private const VALID_TYPES = [
        'BGDIA' => self::BGDIA,
        'DMG' => self::DMG,
        'FTD' => self::FTD,
        'MM' => self::MM,
        'PHB' => self::PHB,
        'TCE' => self::TCE,
        'XGE' => self::XGE,
    ];

    public function __construct(string $book)
    {
        $this->assertValidBook($book);
        parent::__construct($book);
    }

    private function assertValidBook(string $book): void
    {
        if (!isset(self::VALID_TYPES[strtoupper($book)])) {
            throw new InvalidSourceBook($book);
        }
    }
}
