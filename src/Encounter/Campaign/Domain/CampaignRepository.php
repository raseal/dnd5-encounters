<?php

declare(strict_types=1);

namespace Encounter\Campaign\Domain;

interface CampaignRepository
{
    public function save(Campaign $campaign): void;

    public function findById(CampaignId $campaignId): ?Campaign;
}
