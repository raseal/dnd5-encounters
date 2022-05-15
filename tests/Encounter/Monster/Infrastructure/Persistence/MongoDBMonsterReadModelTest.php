<?php

declare(strict_types=1);

namespace Test\Encounter\Monster\Infrastructure\Persistence;

use Encounter\Monster\Application\Search\MonstersViewModel;
use Encounter\Monster\Application\Search\MonsterViewModel;
use Encounter\Monster\Infrastructure\Persistence\MongoDBMonsterReadModel;
use Shared\Domain\Criteria\Criteria;
use Test\Encounter\Monster\Application\Search\MonsterViewModelMother;
use Test\MongoDBTestCase;
use Test\Shared\Domain\Criteria\CriteriaMother;
use Test\Shared\Domain\Criteria\Filter\FilterFieldMother;
use Test\Shared\Domain\Criteria\Filter\FilterMother;
use Test\Shared\Domain\Criteria\Filter\FilterOperatorMother;
use Test\Shared\Domain\Criteria\Filter\FiltersMother;
use Test\Shared\Domain\Criteria\Filter\FilterValueMother;
use Test\Shared\Domain\Criteria\LimitMother;
use Test\Shared\Domain\Criteria\OffsetMother;
use function current;

final class MongoDBMonsterReadModelTest extends MongoDBTestCase
{
    private MongoDBMonsterReadModel $mongoDBMonsterReadModel;

    public function setUp(): void
    {
        $this->mongoDBMonsterReadModel = new MongoDBMonsterReadModel(
            $this->client(),
            self::TEST_DATABASE
        );
    }

    /** @test */
    public function should_get_a_monster(): void
    {
        $sample = MonsterViewModelMother::random();
        $convertedMonster = $this->monsterViewModelToArray($sample);
        $criteria = $this->generateCriteria('name', 'like', $sample->name());
        $this->saveSingleRecord($convertedMonster);

        $monstersCollection = $this->mongoDBMonsterReadModel->search($criteria);
        $monster = $this->getFirst($monstersCollection);

        $this->assertEquals($sample->name(), $monster->name());
        $this->assertEquals($sample->size(), $monster->size());
        $this->assertEquals($sample->type(), $monster->type());
        $this->assertEquals($sample->source(), $monster->source());
        $this->assertEquals($sample->page(), $monster->page());
        $this->assertEquals($sample->ac(), $monster->ac());
        $this->assertEquals($sample->hp(), $monster->hp());
        $this->assertEquals($sample->str(), $monster->str());
        $this->assertEquals($sample->dex(), $monster->dex());
        $this->assertEquals($sample->con(), $monster->con());
        $this->assertEquals($sample->int(), $monster->int());
        $this->assertEquals($sample->wis(), $monster->wis());
        $this->assertEquals($sample->cha(), $monster->cha());
        $this->assertEquals($sample->skills(), $monster->skills());
        $this->assertEquals($sample->senses(), $monster->senses());
        $this->assertEquals($sample->immunities(), $monster->immunities());
        $this->assertEquals($sample->cr(), $monster->cr());
        $this->assertEquals($sample->actions(), $monster->actions());
        $this->assertEquals($sample->traits(), $monster->traits());
        $this->assertEquals($sample->legendaryActions(), $monster->legendaryActions());
        $this->assertStringContainsString($sample->tokenURL(), $monster->tokenURL());
        $this->assertStringContainsString($sample->speed(), $monster->speed());
        $this->assertStringContainsString($sample->savings(), $monster->savings());
    }

    private function monsterViewModelToArray(MonsterViewModel $monsterViewModel): array
    {
        return [
            'name' => $monsterViewModel->name(),
            'size' => [$monsterViewModel->size()],
            'type' => $monsterViewModel->type(),
            'source' => $monsterViewModel->source(),
            'page' => $monsterViewModel->page(),
            'ac' => [$monsterViewModel->ac()],
            'hp' => $monsterViewModel->hp(),
            'speed' => $monsterViewModel->speed(),
            'str' => $monsterViewModel->str(),
            'dex' => $monsterViewModel->dex(),
            'con' => $monsterViewModel->con(),
            'int' => $monsterViewModel->int(),
            'wis' => $monsterViewModel->wis(),
            'cha' => $monsterViewModel->cha(),
            'save' => $monsterViewModel->savings(),
            'skill' => $monsterViewModel->skills(),
            'senses' => $monsterViewModel->senses(),
            'immune' => $monsterViewModel->immunities(),
            'cr' => $monsterViewModel->cr(),
            'action' => $monsterViewModel->actions(),
            'trait' => $monsterViewModel->traits(),
            'legendary' => $monsterViewModel->legendaryActions()
        ];
    }

    private function generateCriteria(string $field, string $operator, string $value, int $offset = 0, int $limit =1): Criteria
    {
        return CriteriaMother::create(
            FiltersMother::create([
                FilterMother::create(
                    FilterFieldMother::create($field),
                    FilterOperatorMother::create($operator),
                    FilterValueMother::create($value)
                )
            ]),
            OffsetMother::create($offset),
            LimitMother::create($limit)
        );
    }

    private function getFirst(MonstersViewModel $collection): MonsterViewModel
    {
        return current($collection)[0];
    }
}
