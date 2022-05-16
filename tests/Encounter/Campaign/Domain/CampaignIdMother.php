<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Domain;

use Encounter\Campaign\Domain\CampaignId;
use Faker\Factory;

final class CampaignIdMother
{
    public static function create(string $id): CampaignId
    {
        return new CampaignId($id);
    }

    public static function random(): CampaignId
    {
        return self::create(Factory::create()->uuid());
    }
}
