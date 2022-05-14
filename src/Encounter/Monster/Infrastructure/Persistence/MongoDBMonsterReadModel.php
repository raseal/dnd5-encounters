<?php

declare(strict_types=1);

namespace Encounter\Monster\Infrastructure\Persistence;

use Encounter\Monster\Application\MonsterReadModel;
use Encounter\Monster\Application\Search\MonstersViewModel;
use Encounter\Monster\Application\Search\MonsterViewModel;
use MongoDB\Client;
use MongoDB\Driver\Query;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter\Filter;
use Shared\Domain\Criteria\Filter\Filters;
use Shared\Infrastructure\Persistence\MongoDB\MongoDBCriteriaConverter;

final class MongoDBMonsterReadModel implements MonsterReadModel
{
    private const MONSTER_COLLECTION = 'monster';
    private const LIMIT = 'limit';
    private const OFFSET = 'skip';
    private const SORT = 'sort';
    private string $namespace;

    public function __construct(
        private Client $client,
        private string $mongoDBEncounters
    ) {
        $this->namespace = $this->mongoDBEncounters.'.'.self::MONSTER_COLLECTION;
    }

    public function search(Criteria $criteria): MonstersViewModel
    {
        $query = new Query(
            $this->transformFilters($criteria->filters()),
            [
                self::LIMIT => $criteria->limit()->value(),
                self::OFFSET => $criteria->offset()->value(),
                self::SORT => $this->sortedByName(),
            ],
        );

        $monsters = $this->client->getManager()->executeQuery($this->namespace, $query);
        $monstersView = new MonstersViewModel([]);

        foreach ($monsters as $monster) {
            $normalized = MongoDBMonsterDataNormalizer::normalize((array)$monster);
            $monstersView->add(
                MonsterViewModel::fromArray($normalized)
            );
        }

        return $monstersView;
    }

    private function transformFilters(Filters $filters): array
    {
        $transformedFilters = [];

        /** @var Filter $filter */
        foreach ($filters as $filter) {
            $transformedFilters = array_merge(MongoDBCriteriaConverter::transform($filter), $transformedFilters);
        }

        return $transformedFilters;
    }

    private function sortedByName(): array
    {
        return ['name' => 1];
    }
}
