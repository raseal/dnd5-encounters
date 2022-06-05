<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application\GetOneCampaign;

use Shared\Domain\Bus\Query\Query;

final class GetOneCampaignQuery implements Query
{
    public function __construct(
        private string $campaignId
    ) {}

    public function campaignId(): string
    {
        return $this->campaignId;
    }
}
