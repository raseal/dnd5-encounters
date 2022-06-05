<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application;

use Encounter\Campaign\Domain\Campaign;
use Shared\Domain\Bus\Query\QueryResponse;

final class CampaignResponse implements QueryResponse
{
    public function __construct(
        private string $campaignId,
        private string $campaignName,
        private bool $active
    ) {}

    public static function fromCampaign(Campaign $campaign): self
    {
        return new self(
            $campaign->campaignId()->value(),
            $campaign->campaignName()->value(),
            $campaign->campaignActive()->value()
        );
    }

    public function campaignId(): string
    {
        return $this->campaignId;
    }

    public function campaignName(): string
    {
        return $this->campaignName;
    }

    public function active(): bool
    {
        return $this->active;
    }
}
