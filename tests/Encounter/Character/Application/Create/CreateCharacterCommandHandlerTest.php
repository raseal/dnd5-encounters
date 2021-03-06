<?php

declare(strict_types=1);

namespace Test\Encounter\Character\Application\Create;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaign;
use Encounter\Campaign\Domain\CampaignRepository;
use Encounter\Campaign\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Application\Create\CreateCharacter;
use Encounter\Character\Application\Create\CreateCharacterCommandHandler;
use Encounter\Character\Domain\CharacterRepository;
use Encounter\Character\Domain\Exception\CharacterAlreadyExists;
use Encounter\Character\Domain\Exception\InvalidCharacterLevel;
use PHPUnit\Framework\TestCase;
use Test\Encounter\Campaign\Domain\CampaignMother;
use Test\Encounter\Character\Domain\CharacterIdMother;
use Test\Encounter\Character\Domain\CharacterMother;

final class CreateCharacterCommandHandlerTest extends TestCase
{
    private CharacterRepository $characterRepository;
    private CampaignRepository $campaignRepository;
    private CreateCharacterCommandHandler $createCharacterCommandHandler;

    protected function setUp(): void
    {
        $this->characterRepository = $this->createMock(CharacterRepository::class);
        $this->campaignRepository = $this->createMock(CampaignRepository::class);
        $this->createCharacterCommandHandler = new CreateCharacterCommandHandler(
            new CreateCharacter(
                $this->characterRepository,
                new GetOneCampaign(
                    $this->campaignRepository
                )
            )
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->characterRepository,
            $this->campaignRepository,
            $this->createCharacterCommandHandler
        );
    }

    /** @test */
    public function should_create_character(): void
    {
        $command = CreateCharacterCommandMother::random();
        $campaign = CampaignMother::random();
        $characterId = CharacterIdMother::create($command->characterId());

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn($campaign);

        $this->characterRepository
            ->expects($this->once())
            ->method('findById')
            ->with($characterId)
            ->willReturn(null);

        $this->characterRepository
            ->expects(self::once())
            ->method('save');

        $this->createCharacterCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_character_exists(): void
    {
        $this->expectException(CharacterAlreadyExists::class);

        $command = CreateCharacterCommandMother::random();
        $character = CharacterMother::random();

        $this->characterRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($character);

        $this->createCharacterCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_campaign_does_not_exist(): void
    {
        $this->expectException(CampaignDoesNotExist::class);

        $command = CreateCharacterCommandMother::random();

        $this->campaignRepository
            ->expects(self::once())
            ->method('findById')
            ->willReturn(null);

        $this->characterRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $this->createCharacterCommandHandler->__invoke($command);
    }

    /** @test */
    public function should_fail_when_character_exceeds_level(): void
    {
        $this->expectException(InvalidCharacterLevel::class);

        $command = CreateCharacterCommandMother::fromCharacterLevel(23);

        $this->createCharacterCommandHandler->__invoke($command);
    }
}
