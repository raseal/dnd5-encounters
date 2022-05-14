<?php

declare(strict_types=1);

namespace Encounter\Monster\Application\Search;

use Encounter\Monster\Application\MonsterResponse;
use Encounter\Monster\Application\MonstersResponse;
use Shared\Domain\Bus\Query\QueryHandler;
use Shared\Domain\Criteria\Filter\FilterOperator;
use Shared\Domain\Criteria\Filter\Filters;
use Shared\Domain\Criteria\Limit;
use Shared\Domain\Criteria\Offset;

final class SearchMonstersQueryHandler implements QueryHandler
{
    private const NAME = 'name';
    private const SOURCE = 'source';

    private const VALID_FILTERS = [
        self::NAME => [
            FilterOperator::LIKE,
            FilterOperator::EQ,
        ],
        self::SOURCE => [
            FilterOperator::LIKE,
            FilterOperator::EQ,
        ],
    ];

    public function __construct(
        private SearchMonsters $searchMonsters
    ) {}

    public function __invoke(SearchMonstersQuery $searchMonstersQuery): MonstersResponse
    {
        $filters = Filters::fromValues($searchMonstersQuery->filters(), self::VALID_FILTERS);
        $offset = Offset::fromPage($searchMonstersQuery->page(), $searchMonstersQuery->limit());

        $monsters = $this->searchMonsters->__invoke(
            $filters,
            $offset,
            new Limit($searchMonstersQuery->limit())
        );

        $response = new MonstersResponse([]);

        /** @var MonsterViewModel $monster */
        foreach ($monsters as $monster) {
            $response->add(
                MonsterResponse::fromMonsterViewModel($monster)
            );
        }

        return $response;
    }
}
