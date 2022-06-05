<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application\GetOneCampaign;

use Encounter\Campaign\Domain\Campaign;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Character\Domain\Exception\CampaignDoesNotExist;

final class GetOneCampaign
{
    public function __construct(
        private CampaignRepository $campaignRepository
    ) {}

    public function __invoke(CampaignId $campaignId): Campaign
    {
        $campaign = $this->campaignRepository->findById($campaignId);

        if (null === $campaign) {
            throw new CampaignDoesNotExist($campaignId->value());
        }

        return $campaign;
    }
}
