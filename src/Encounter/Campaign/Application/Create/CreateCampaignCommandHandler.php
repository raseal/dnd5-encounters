<?php

declare(strict_types=1);

namespace Encounter\Campaign\Application\Create;

use Encounter\Campaign\Domain\CampaignActive;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignName;
use Shared\Domain\Bus\Command\CommandHandler;

final class CreateCampaignCommandHandler implements CommandHandler
{
    public function __construct(
        private CreateCampaign $createCampaign
    ) {}

    public function __invoke(CreateCampaignCommand $command): void
    {
        $this->createCampaign->__invoke(
            new CampaignId($command->campaignId()),
            new CampaignName($command->campaignName()),
            new CampaignActive($command->campaignActive())
        );
    }
}
