<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Infrastructure\Persistence;

use Encounter\Campaign\Domain\Campaign;
use Encounter\Campaign\Infrastructure\Persistence\DBALCampaignRepository;
use Test\DBALTestCase;
use Test\Encounter\Campaign\Domain\CampaignMother;

final class DBALCampaignRepositoryTest extends DBALTestCase
{
    private DBALCampaignRepository $campaignRepository;

    public function setUp(): void
    {
        $this->campaignRepository = new DBALCampaignRepository($this->connection());
        parent::setUp();
    }

    /** @test */
    public function should_save_a_campaign(): void
    {
        $campaign = CampaignMother::random();

        $this->campaignRepository->save($campaign);
    }

    /** @test */
    public function should_get_a_campaign(): void
    {
        $campaign = CampaignMother::random();

        $this->campaignRepository->save($campaign);

        $storedCampaign = $this->campaignRepository->findById($campaign->campaignId());

        $this->assertInstanceOf(Campaign::class, $storedCampaign);
        $this->assertEquals($campaign, $storedCampaign);
    }
}
