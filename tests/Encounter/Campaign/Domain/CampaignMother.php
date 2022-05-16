<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Domain;

use Encounter\Campaign\Domain\Campaign;
use Encounter\Campaign\Domain\CampaignActive;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignName;

final class CampaignMother
{
    public static function create(
        CampaignId $id,
        CampaignName $name,
        CampaignActive $active): Campaign {
        return new Campaign($id, $name, $active);
    }

    public static function random(): Campaign
    {
        return self::create(
            CampaignIdMother::random(),
            CampaignNameMother::random(),
            CampaignActiveMother::random()
        );
    }
}
