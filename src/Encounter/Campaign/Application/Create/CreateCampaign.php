<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application\Create;

use Encounter\Campaign\Domain\Campaign;
use Encounter\Campaign\Domain\CampaignActive;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignName;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Campaign\Domain\Exception\CampaignAlreadyExists;

final class CreateCampaign
{
    public function __construct(
        private CampaignRepository $campaignRepository
    ) {}

    public function __invoke(CampaignId $campaignId, CampaignName $campaignName, CampaignActive $campaignActive): void
    {
        $this->ensureCampaignDoesNotExist($campaignId);

        $this->campaignRepository->save(
            new Campaign(
                $campaignId,
                $campaignName,
                $campaignActive
            )
        );
    }

    private function ensureCampaignDoesNotExist(CampaignId $campaignId): void
    {
        $campaign = $this->campaignRepository->findById($campaignId);

        if (null !== $campaign) {
            throw new CampaignAlreadyExists($campaign->campaignId()->value());
        }
    }
}
