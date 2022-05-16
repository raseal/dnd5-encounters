<?php

declare(strict_types=1);

namespace Encounter\Campaign\Domain;

final class Campaign
{
    public function __construct(
        private CampaignId $campaignId,
        private CampaignName $campaignName,
        private CampaignActive $campaignActive
    ) {}

    public function campaignId(): CampaignId
    {
        return $this->campaignId;
    }

    public function campaignName(): CampaignName
    {
        return $this->campaignName;
    }

    public function campaignActive(): CampaignActive
    {
        return $this->campaignActive;
    }

    public function activate(): void
    {
        $this->campaignActive = new CampaignActive(true);
    }
}
