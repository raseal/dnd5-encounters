<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaign;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Application\GetOneCharacter\GetOneCharacter;
use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\Characters;
use Encounter\Character\Domain\Exception\CharacterDoesNotBelongToCampaign;
use Encounter\Encounter\Domain\CharacterIds;
use Encounter\Encounter\Domain\Difficulty;
use Encounter\Encounter\Domain\Encounter;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterInProgress;
use Encounter\Encounter\Domain\EncounterName;
use Encounter\Encounter\Domain\EncounterRepository;
use Encounter\Encounter\Domain\Exception\EncounterAlreadyExists;
use Encounter\Encounter\Domain\ExperiencePerPlayer;
use Encounter\Encounter\Domain\MonsterIds;
use Encounter\Encounter\Domain\RoundNumber;
use Encounter\Encounter\Domain\TotalExperience;
use Encounter\Encounter\Domain\TurnNumber;
use Encounter\Monster\Application\GetOneMonster\GetOneMonster;
use Encounter\Monster\Domain\MonsterId;
use Encounter\Monster\Domain\Monsters;

final class CreateEncounter
{
    public function __construct(
        private GetOneCharacter $getOneCharacter,
        private EncounterRepository $encounterRepository,
        private GetOneCampaign $getOneCampaign,
        private GetOneMonster $getOneMonster
    ) {}

    public function __invoke(
        EncounterId $encounterId,
        CampaignId $campaignId,
        EncounterInProgress $inProgress,
        EncounterName $encounterName,
        RoundNumber $roundNumber,
        TurnNumber $turnNumber,
        MonsterIds $monsterIds,
        CharacterIds $characterIds
    ): void {
        $this->ensureCampaignExists($campaignId);
        $this->ensureEncounterDoesNotExist($encounterId);
        $characters = $this->retrieveCharacters($characterIds);
        $monsters = $this->retrieveMonsters($monsterIds);
        $this->ensurePlayersBelongToTheCampaign($campaignId, $characters);

        $encounter = new Encounter(
            $encounterId,
            $campaignId,
            Difficulty::none(),
            $inProgress,
            $encounterName,
            new TotalExperience(0),
            new ExperiencePerPlayer(0),
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

    private function retrieveCharacters(CharacterIds $characterIds): Characters
    {
        $characters = new Characters([]);

        /** @var CharacterId $characterId */
        foreach ($characterIds as $characterId) {
            $characters->add(
                $this->getOneCharacter->__invoke($characterId)
            );
        }

        return $characters;
    }

    private function retrieveMonsters(MonsterIds $monsterIds): Monsters
    {
        $monsters = new Monsters([]);

        /** @var MonsterId $monsterId */
        foreach ($monsterIds as $monsterId) {
            $monsters->add(
                $this->getOneMonster->__invoke($monsterId)
            );
        }

        return $monsters;
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
