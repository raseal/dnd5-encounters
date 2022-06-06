<?php

declare(strict_types=1);

namespace Encounter\Monster\Domain;

use Encounter\Monster\Domain\Exception\InvalidMonsterIdStructure;
use function json_decode;
use function json_encode;

final class MonsterId
{
    private const MONSTER_NAME = 'monsterName';
    private const SOURCE_BOOK = 'sourceBook';

    public function __construct(
        private MonsterName $monsterName,
        private SourceBook $sourceBook
    ) {}

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        self::ensureValidStructure($data);

        return new self(
            new MonsterName($data[self::MONSTER_NAME]),
            new SourceBook($data[self::SOURCE_BOOK])
        );
    }

    public function value(): string
    {
        return json_encode(
            [
                self::MONSTER_NAME => $this->monsterName->value(),
                self::SOURCE_BOOK => $this->sourceBook->value(),
            ]
        );
    }

    public function monsterName(): MonsterName
    {
        return $this->monsterName;
    }

    public function sourceBook(): SourceBook
    {
        return $this->sourceBook;
    }

    private static function ensureValidStructure(array $data): void
    {
        if (!isset($data[self::MONSTER_NAME]) || !isset($data[self::SOURCE_BOOK])) {
            throw new InvalidMonsterIdStructure(json_encode($data));
        }
    }
}
