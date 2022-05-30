<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterIds;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Domain\Exception\CharacterDoesNotBelongToCampaign;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;
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
        private CampaignRepository $campaignRepository,
        private CharacterRepository $characterRepository,
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
        CharacterIds $characterIds
    ): void {
        $this->ensureCampaignExists($campaignId);
        $this->ensureEncounterDoesNotExist($encounterId);
        $this->ensurePlayersBelongToTheCampaign($campaignId, $characterIds);

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
        $encounter->addPlayersIds($characterIds);

        $this->encounterRepository->save($encounter);
    }

    private function ensureCampaignExists(CampaignId $campaignId): void
    {
        $campaign = $this->campaignRepository->findById($campaignId);

        if (null === $campaign) {
            throw new CampaignDoesNotExist($campaignId->value());
        }
    }

    private function ensureEncounterDoesNotExist(EncounterId $encounterId): void
    {
        $encounter = $this->encounterRepository->findById($encounterId);

        if (null !== $encounter) {
            throw new EncounterAlreadyExists($encounterId->value());
        }
    }

    private function ensurePlayersBelongToTheCampaign(CampaignId $campaignId, CharacterIds $characterIds): void
    {
        /** @var CharacterId $characterId */
        foreach ($characterIds as $characterId) {
            $character = $this->characterRepository->findById($characterId);

            if (null === $character) {
                throw new CharacterDoesNotExist($characterId->value());
            }

            if ($character->campaignId()->value() !== $campaignId->value()) {
                throw new CharacterDoesNotBelongToCampaign($characterId->value(), $campaignId->value());
            }
        }
    }
}
