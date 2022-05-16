<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application\Create;

use Shared\Domain\Bus\Command\Command;

final class CreateCampaignCommand implements Command
{
    public function __construct(
        private string $campaignId,
        private string $campaignName,
        private bool $campaignActive
    ) {}

    public function campaignId(): string
    {
        return $this->campaignId;
    }

    public function campaignName(): string
    {
        return $this->campaignName;
    }

    public function campaignActive(): bool
    {
        return $this->campaignActive;
    }
}
