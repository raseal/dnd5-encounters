<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Domain;

use Encounter\Campaign\Domain\CampaignName;
use Faker\Factory;

final class CampaignNameMother
{
    public static function create(string $name): CampaignName
    {
        return new CampaignName($name);
    }

    public static function random(): CampaignName
    {
        return self::create(Factory::create()->text(10));
    }
}
