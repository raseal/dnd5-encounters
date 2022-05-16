<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Application\Search;

use Encounter\Monster\Application\MonsterReadModel;
use Encounter\Monster\Application\Search\SearchMonsters;
use Encounter\Monster\Application\Search\SearchMonstersQueryHandler;
use PHPUnit\Framework\TestCase;
use Test\Encounter\Monster\Application\MonstersResponseMother;
use Test\Shared\Domain\Criteria\CriteriaMother;

final class SearchMonstersQueryHandlerTest extends TestCase
{
    private MonsterReadModel $monsterReadModel;
    private SearchMonstersQueryHandler $searchMonstersQueryHandler;

    protected function setUp(): void
    {
        $this->monsterReadModel = $this->createMock(MonsterReadModel::class);
        $this->searchMonstersQueryHandler = new SearchMonstersQueryHandler(
            new SearchMonsters($this->monsterReadModel)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->monsterReadModel,
            $this->searchMonstersQueryHandler
        );
    }

    /** @test */
    public function shouldReturnMonsters(): void
    {
        $criteria = CriteriaMother::withFieldAndOperator('name', 'like');
        $monstersViewModel = MonstersViewModelMother::random();
        $expectedResponse = MonstersResponseMother::createFromViewModel($monstersViewModel);

        $this->monsterReadModel
            ->expects(self::once())
            ->method('search')
            ->with($criteria)
            ->willReturn($monstersViewModel);

        $response = $this->searchMonstersQueryHandler->__invoke(
            SearchMonstersQueryMother::fromCriteria($criteria)
        );

        $this->assertEquals($expectedResponse, $response);
    }
}
