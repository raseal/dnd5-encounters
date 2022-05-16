<?php

declare(strict_types=1);

namespace Encounter\Campaign\Domain\Exception;

use Shared\Domain\Exception\DomainError;

final class CampaignAlreadyExists extends DomainError
{
    private string $campaignId;

    public function __construct(string $id)
    {
        $this->campaignId = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Campaign_already_exists';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The campaign %s already exists',
            $this->campaignId
        );
    }
}
