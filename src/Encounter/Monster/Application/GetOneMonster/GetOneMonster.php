<?php

declare(strict_types=1);

namespace Encounter\Monster\Application\GetOneMonster;

use Encounter\Monster\Application\Search\SearchMonsters;
use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\Exception\MonsterDoesNotExist;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterHPAverage;
use Encounter\Monster\Domain\MonsterHPMax;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\SourceBook;
use Shared\Domain\Criteria\Filter\FilterOperator;
use Shared\Domain\Criteria\Filter\Filters;
use Shared\Domain\Criteria\Limit;
use Shared\Domain\Criteria\Offset;
use Shared\Domain\Utils;

final class GetOneMonster
{
    private const NAME = 'name';
    private const SOURCE = 'source';
    private const PAGE = 1;
    private const LIMIT = 1;

    private const VALID_FILTERS = [
        self::NAME => [
            FilterOperator::LIKE,
        ],
        self::SOURCE => [
            FilterOperator::LIKE,
        ],
    ];

    public function __construct(
        private SearchMonsters $searchMonsters
    ) {}

    public function __invoke(MonsterId $monsterId): Monster
    {
        $monstersViewModel = $this->searchMonsters->__invoke(
            $this->buildFilters($monsterId),
            $this->buildOffset(),
            $this->buildLimit()
        );

        $monster = Utils::first($monstersViewModel);

        if (null === $monster) {
            throw new MonsterDoesNotExist($monsterId->value());
        }

        return new Monster(
            $monsterId,
            new MonsterName($monster->name()),
            new SourceBook($monster->source()),
            new ChallengeRating((float) $monster->cr()),
            new MonsterHPAverage($monster->hp()['average']),
            MonsterHPMax::fromFormula($monster->hp()['formula'])
        );
    }

    private function buildFilters(MonsterId $monsterId): Filters
    {
        return Filters::fromValues(
            [
                self::NAME => [FilterOperator::LIKE => $monsterId->monsterName()->value()],
                self::SOURCE => [FilterOperator::LIKE => $monsterId->sourceBook()->value()],
            ],
            self::VALID_FILTERS
        );
    }

    private function buildOffset(): Offset
    {
        return Offset::fromPage(self::PAGE, self::LIMIT);
    }

    private function buildLimit(): Limit
    {
        return new Limit(self::LIMIT);
    }
}
