<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Application\GetOneCampaign;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaign;
use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaignQueryHandler;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Character\Domain\Exception\CampaignDoesNotExist;
use PHPUnit\Framework\TestCase;
use Test\Encounter\Campaign\Domain\CampaignMother;

final class GetOneCampaignQueryHandlerTest extends TestCase
{
    private CampaignRepository $campaignRepository;
    private GetOneCampaignQueryHandler $getOneCampaignQueryHandler;

    public function setUp(): void
    {
        $this->campaignRepository = $this->createMock(CampaignRepository::class);
        $this->getOneCampaignQueryHandler = new GetOneCampaignQueryHandler(
            new GetOneCampaign(
                $this->campaignRepository
            )
        );
    }

    public function tearDown(): void
    {
        unset(
            $this->campaignRepository,
            $this->getOneCampaignQueryHandler
        );
    }

    /** @test */
    public function should_find_a_campaign(): void
    {
        $query = GetOneCampaignQueryMother::random();
        $campaign = CampaignMother::random();

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->getOneCampaignQueryHandler->__invoke($query);
    }

    /** @test */
    public function should_fail_when_campaign_does_not_exist(): void
    {
        $this->expectException(CampaignDoesNotExist::class);

        $query = GetOneCampaignQueryMother::random();

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $this->getOneCampaignQueryHandler->__invoke($query);
    }
}
