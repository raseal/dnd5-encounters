<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application\GetOneCampaign;

use Encounter\Campaign\Application\CampaignResponse;
use Encounter\Campaign\Domain\CampaignId;
use Shared\Domain\Bus\Query\QueryHandler;

final class GetOneCampaignQueryHandler implements QueryHandler
{
    public function __construct(
        private GetOneCampaign $getOneCampaign
    ) {}

    public function __invoke(GetOneCampaignQuery $campaignQuery): CampaignResponse
    {
        $campaign = $this->getOneCampaign->__invoke(
            new CampaignId($campaignQuery->campaignId())
        );

        return CampaignResponse::fromCampaign($campaign);
    }
}
