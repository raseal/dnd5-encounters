<?php

declare(strict_types=1);

namespace Encounter\Character\Domain\Exception;

use Shared\Domain\Exception\DomainError;

final class CampaignDoesNotExist extends DomainError
{
    private string $campaignId;

    public function __construct(string $id)
    {
        $this->campaignId = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Campaign_does_not_exist';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The selected campaign %s does not exist',
            $this->campaignId
        );
    }
}
