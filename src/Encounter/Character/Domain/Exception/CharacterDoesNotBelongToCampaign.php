<?php

declare(strict_types=1);

namespace Encounter\Character\Domain\Exception;

use Shared\Domain\Exception\DomainError;
use function sprintf;

final class CharacterDoesNotBelongToCampaign extends DomainError
{
    private string $characterId;
    private string $campaignId;

    public function __construct(string $characterId, string $campaignId)
    {
        $this->characterId = $characterId;
        $this->campaignId = $campaignId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Character_does_not_belong_to_campaign';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'The character %s does not belong to campaign %s',
            $this->characterId,
            $this->campaignId
        );
    }
}
