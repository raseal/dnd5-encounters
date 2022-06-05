<?php

declare(strict_types=1);

namespace Encounter\Encounter\Application\Create;

use Encounter\Campaign\Domain\CampaignId;
use Encounter\Character\Domain\Character;
use Encounter\Character\Domain\CharacterId;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\Characters;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;
use Encounter\Encounter\Domain\EncounterId;
use Encounter\Encounter\Domain\EncounterInProgress;
use Encounter\Encounter\Domain\EncounterName;
use Encounter\Encounter\Domain\RoundNumber;
use Encounter\Encounter\Domain\TurnNumber;
use Encounter\Monster\Application\Search\MonsterViewModel;
use Encounter\Monster\Application\Search\SearchMonsters;
use Encounter\Monster\Domain\ChallengeRating;
use Encounter\Monster\Domain\Exception\MonsterDoesNotExist;
use Encounter\Monster\Domain\InitiativeBonus;
use Encounter\Monster\Domain\Monster;
use Encounter\Monster\Domain\MonsterArmorClass;
use Encounter\Monster\Domain\MonsterHPAverage;
use Encounter\Monster\Domain\MonsterHPMax;
use Encounter\Monster\Domain\MonsterImg;
use Encounter\Monster\Domain\MonsterName;
use Encounter\Monster\Domain\Monsters;
use Encounter\Monster\Domain\MonsterSize;
use Encounter\Monster\Domain\Page;
use Encounter\Monster\Domain\SourceBook;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\Criteria\Filter\FilterOperator;
use Shared\Domain\Criteria\Filter\Filters;
use Shared\Domain\Criteria\Limit;
use Shared\Domain\Criteria\Offset;
use function Lambdish\Phunctional\first;

final class CreateEncounterCommandHandler implements CommandHandler
{
    private const NAME = 'name';
    private const SOURCE = 'source';

    private const VALID_FILTERS = [
        self::NAME => [
            FilterOperator::LIKE,
        ],
        self::SOURCE => [
            FilterOperator::LIKE,
        ],
    ];

    public function __construct(
        private CreateEncounter $createEncounter,
        private CharacterRepository $characterRepository,
        private SearchMonsters $searchMonsters
    ) {}

    public function __invoke(CreateEncounterCommand $command): void
    {
        $this->createEncounter->__invoke(
            new EncounterId($command->encounterId()),
            new CampaignId($command->campaignId()),
            new EncounterInProgress($command->inProgress()),
            new EncounterName($command->encounterName()),
            new RoundNumber($command->round()),
            new TurnNumber($command->turn()),
            $this->parseMonsters($command->monsters()),
            $this->parseCharacters($command->players())
        );
    }

    private function parseMonsters(array $monsters): Monsters
    {
        $collection = new Monsters([]);

        foreach ($monsters as $data) {
            $monster = $this->retrieveMonster($data['name'], $data['sourceBook']);

            for ($i = 0; $i < $data['quantity']; $i++) {
                $collection->add($monster);
            }
        }

        return $collection;
    }

    private function retrieveMonster(string $name, string $sourceBook): Monster
    {
        $searchFilters = [
            self::NAME => [FilterOperator::LIKE => $name],
            self::SOURCE => [FilterOperator::LIKE => $sourceBook],
        ];

        $monstersViewModel = $this->searchMonsters->__invoke(
            Filters::fromValues($searchFilters, self::VALID_FILTERS),
            Offset::fromPage(1, 1),
            new Limit(1)
        );

        /** @var MonsterViewModel $monster */
        $monster = first($monstersViewModel);

        if (null === $monster) {
            throw new MonsterDoesNotExist($name);
        }

        return new Monster(
            null,
            new MonsterName($monster->name()),
            new SourceBook($monster->source()),
            new Page($monster->page()),
            MonsterSize::fromAbbreviation($monster->size()),
            new ChallengeRating((float) $monster->cr()),
            new MonsterImg($monster->tokenURL()),
            InitiativeBonus::fromDexterity($monster->dex()),
            new MonsterHPAverage($monster->hp()['average']),
            MonsterHPMax::fromFormula($monster->hp()['formula']),
            new MonsterArmorClass($monster->ac())
        );
    }

    private function parseCharacters(array $players): Characters
    {
        $collection = new Characters([]);

        foreach ($players as $player) {
            $collection->add(
                $this->retrieveCharacter($player)
            );
        }

        return $collection;
    }

    private function retrieveCharacter(string $characterId): Character
    {
        $character = $this->characterRepository->findById(new CharacterId($characterId));

        if (null === $character) {
            throw new CharacterDoesNotExist($characterId);
        }

        return $character;
    }
}
