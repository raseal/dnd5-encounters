<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Domain;

use Encounter\Campaign\Domain\CampaignActive;
use Faker\Factory;

final class CampaignActiveMother
{
    public static function create(bool $active): CampaignActive
    {
        return new CampaignActive($active);
    }

    public static function random(): CampaignActive
    {
        return self::create(Factory::create()->boolean());
    }
}
