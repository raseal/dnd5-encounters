<?php

declare(strict_types=1);

namespace Test\Encounter\Encounter\Application\Create;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaign;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Campaign\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Application\GetOneCharacter\GetOneCharacter;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\Exception\CharacterDoesNotBelongToCampaign;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;
use Encounter\Encounter\Application\Create\CreateEncounter;
use Encounter\Encounter\Application\Create\CreateEncounterCommandHandler;
use Encounter\Encounter\Domain\EncounterRepository;
use Encounter\Encounter\Domain\Exception\EncounterAlreadyExists;
use Encounter\Monster\Application\GetOneMonster\GetOneMonster;
use Encounter\Monster\Application\MonsterReadModel;
use Encounter\Monster\Application\Search\SearchMonsters;
use Encounter\Monster\Domain\Exception\MonsterDoesNotExist;
use PHPUnit\Framework\TestCase;
use Test\Encounter\Campaign\Domain\CampaignMother;
use Test\Encounter\Character\Domain\CharacterMother;
use Test\Encounter\Encounter\Domain\EncounterMother;
use Test\Encounter\Monster\Application\Search\MonstersViewModelMother;

final class CreateEncounterCommandHandlerTest extends TestCase
{
    private EncounterRepository $encounterRepository;
    private CampaignRepository $campaignRepository;
    private CharacterRepository $characterRepository;
    private MonsterReadModel $monsterReadModel;
    private CreateEncounterCommandHandler $createEncounterCommandHandler;

    protected function setUp(): void
    {
        $this->encounterRepository = $this->createMock(EncounterRepository::class);
        $this->campaignRepository = $this->createMock(CampaignRepository::class);
        $this->characterRepository = $this->createMock(CharacterRepository::class);
        $this->monsterReadModel = $this->createMock(MonsterReadModel::class);

        $this->createEncounterCommandHandler = new CreateEncounterCommandHandler(
            new CreateEncounter(
                new GetOneCharacter(
                    $this->characterRepository
                ),
                $this->encounterRepository,
                new GetOneCampaign(
                    $this->campaignRepository,
                ),
                new GetOneMonster(
                    new SearchMonsters(
                        $this->monsterReadModel
                    )
                )
            )
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->encounterRepository,
            $this->campaignRepository,
            $this->characterRepository,
            $this->createMonsters,
            $this->monsterReadModel,
            $this->createEncounterCommandHandler
        );
    }

    /** @test */
    public function should_create_encounter(): void
    {
        $campaign = CampaignMother::random();
        $command = CreateEncounterCommandMother::fromCampaignId($campaign->campaignId()->value());
        $character = CharacterMother::fromCampaignId($campaign->campaignId());
        $monsters = MonstersViewModelMother::random();

        $this->monsterReadModel
            ->method('search')
            ->willReturn($monsters);

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->characterRepository
            ->expects(self::atLeastOnce())
            ->method('findById')
            ->willReturn($character);

        $this->encounterRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $this->encounterRepository
            ->expects(self::once())
            ->method('save');

        $this->createEncounterCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_monster_does_not_exist(): void
    {
        $this->expectException(MonsterDoesNotExist::class);

        $campaign = CampaignMother::random();
        $character = CharacterMother::fromCampaignId($campaign->campaignId());

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->characterRepository
            ->expects(self::atLeastOnce())
            ->method('findById')
            ->willReturn($character);

        $command = CreateEncounterCommandMother::random();
        $this->createEncounterCommandHandler->__invoke($command);

    }

    /** @test */
    public function should_fail_when_character_does_not_exist(): void
    {
        $this->expectException(CharacterDoesNotExist::class);

        $campaign = CampaignMother::random();
        $monsters = MonstersViewModelMother::random();

        $this->monsterReadModel
            ->method('search')
            ->willReturn($monsters);

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->characterRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $command = CreateEncounterCommandMother::random();
        $this->createEncounterCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_campaign_does_not_exist(): void
    {
        $this->expectException(CampaignDoesNotExist::class);

        $monsters = MonstersViewModelMother::random();

        $this->monsterReadModel
            ->method('search')
            ->willReturn($monsters);

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $command = CreateEncounterCommandMother::random();
        $this->createEncounterCommandHandler->__invoke($command);
    }

    public function should_fail_when_encounter_exists(): void
    {
        $this->expectException(EncounterAlreadyExists::class);

        $campaign = CampaignMother::random();
        $encounter = EncounterMother::random();
        $command = CreateEncounterCommandMother::random();

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->encounterRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($encounter);

        $this->createEncounterCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_player_does_not_belong_to_the_campaign():void
    {
        $this->expectException(CharacterDoesNotBelongToCampaign::class);

        $campaign = CampaignMother::random();
        $command = CreateEncounterCommandMother::fromCampaignId($campaign->campaignId()->value());
        $character = CharacterMother::random();
        $monsters = MonstersViewModelMother::random();

        $this->monsterReadModel
            ->method('search')
            ->willReturn($monsters);

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->characterRepository
            ->expects(self::atLeastOnce())
            ->method('findById')
            ->willReturn($character);

        $this->encounterRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $this->createEncounterCommandHandler->__invoke($command);
    }
}
