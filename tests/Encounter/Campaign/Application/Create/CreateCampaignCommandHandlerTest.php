<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Application\Create;

use Encounter\Campaign\Application\Create\CreateCampaign;
use Encounter\Campaign\Application\Create\CreateCampaignCommandHandler;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Campaign\Domain\Exception\CampaignAlreadyExists;
use PHPUnit\Framework\TestCase;
use Test\Encounter\Campaign\Domain\CampaignIdMother;
use Test\Encounter\Campaign\Domain\CampaignMother;

final class CreateCampaignCommandHandlerTest extends TestCase
{
    private CampaignRepository $campaignRepository;
    private CreateCampaignCommandHandler $createCampaignCommandHandler;

    protected function setUp(): void
    {
        $this->campaignRepository = $this->createMock(CampaignRepository::class);
        $this->createCampaignCommandHandler = new CreateCampaignCommandHandler(
            new CreateCampaign($this->campaignRepository)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->campaignRepository,
            $this->createCampaignCommandHandler
        );
    }

    /** @test */
    public function should_create_campaign(): void
    {
        $command = CreateCampaignCommandMother::random();
        $campaignId = CampaignIdMother::create($command->campaignId());

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->with($campaignId)
            ->willReturn(null);

        $this->campaignRepository
            ->expects(self::once())
            ->method('save');

        $this->createCampaignCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_campaign_exists(): void
    {
        $this->expectException(CampaignAlreadyExists::class);

        $command = CreateCampaignCommandMother::random();
        $campaign = CampaignMother::random();

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->createCampaignCommandHandler->__invoke($command);
    }
}
