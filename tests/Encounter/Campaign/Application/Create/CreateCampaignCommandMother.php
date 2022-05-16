<?php

declare(strict_types=1);

namespace Test\Encounter\Campaign\Application\Create;

use Encounter\Campaign\Application\Create\CreateCampaignCommand;
use Faker\Factory;

final class CreateCampaignCommandMother
{
    public static function create(string $id, string $name, bool $active): CreateCampaignCommand
    {
        return new CreateCampaignCommand($id, $name, $active);
    }

    public static function random(): CreateCampaignCommand
    {
        return self::create(
            Factory::create()->uuid(),
            Factory::create()->text(10),
            Factory::create()->boolean()
        );
    }
}
