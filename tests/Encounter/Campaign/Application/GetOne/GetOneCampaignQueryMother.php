<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Application\GetOne;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaignQuery;
use Faker\Factory;

final class GetOneCampaignQueryMother
{
    public static function create(string $campaignId): GetOneCampaignQuery
    {
        return new GetOneCampaignQuery($campaignId);
    }

    public static function random(): GetOneCampaignQuery
    {
        return self::create(
            Factory::create()->uuid()
        );
    }
}
