<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaign;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\Characters;
use Encounter\Character\Domain\Exception\CharacterDoesNotBelongToCampaign;
use Encounter\Encounter\Domain\Encounter;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterInProgress;
use Encounter\Encounter\Domain\EncounterName;
use Encounter\Encounter\Domain\EncounterRepository;
use Encounter\Encounter\Domain\Exception\EncounterAlreadyExists;
use Encounter\Encounter\Domain\RoundNumber;
use Encounter\Encounter\Domain\TurnNumber;
use Encounter\Monster\Application\Create\CreateMonsters;
use Encounter\Monster\Domain\Monsters;

final class CreateEncounter
{
    public function __construct(
        private EncounterRepository $encounterRepository,
        private GetOneCampaign $getOneCampaign,
        private CreateMonsters $createMonsters
    ) {}

    public function __invoke(
        EncounterId $encounterId,
        CampaignId $campaignId,
        EncounterInProgress $inProgress,
        EncounterName $encounterName,
        RoundNumber $roundNumber,
        TurnNumber $turnNumber,
        Monsters $monsters,
        Characters $characters
    ): void {
        $this->ensureCampaignExists($campaignId);
        $this->ensureEncounterDoesNotExist($encounterId);
        $this->ensurePlayersBelongToTheCampaign($campaignId, $characters);

        $this->createMonsters->__invoke($monsters);

        $encounter = new Encounter(
            $encounterId,
            $campaignId,
            null,
            $inProgress,
            $encounterName,
            null,
            null,
            $roundNumber,
            $turnNumber
        );

        $encounter->addMonsters($monsters);
        $encounter->addCharacters($characters);

        $this->encounterRepository->save($encounter);
    }

    private function ensureCampaignExists(CampaignId $campaignId): void
    {
        $this->getOneCampaign->__invoke($campaignId);
    }

    private function ensureEncounterDoesNotExist(EncounterId $encounterId): void
    {
        $encounter = $this->encounterRepository->findById($encounterId);

        if (null !== $encounter) {
            throw new EncounterAlreadyExists($encounterId->value());
        }
    }

    private function ensurePlayersBelongToTheCampaign(CampaignId $campaignId, Characters $characters): void
    {
        /** @var Character $character */
        foreach ($characters as $character) {
            if ($character->campaignId()->value() !== $campaignId->value()) {
                throw new CharacterDoesNotBelongToCampaign($character->characterId()->value(), $campaignId->value());
            }
        }
    }
}
