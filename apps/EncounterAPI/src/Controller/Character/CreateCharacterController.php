<?php

declare(strict_types=1);

namespace EncounterAPI\Controller\Character;

use Encounter\Character\Application\Create\CreateCharacterCommand;
use Encounter\Character\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Domain\Exception\CharacterAlreadyExists;
use Shared\Domain\Exception\InvalidUuid;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function sprintf;

final class CreateCharacterController extends ApiController
{
    const API_URL = 'characters/%s';

    public function __invoke(Request $request): Response
    {
        $id = Uuid::random()->value();
        $payload = $this->getPayload($request);

        $this->dispatch(
            new CreateCharacterCommand(
                $id,
                $payload['characterName'],
                $payload['playerName'],
                $payload['campaignId'],
                (int) $payload['characterLevel'],
                (int) $payload['characterAc'],
                (int) $payload['characterHp'],
                (int) $payload['characterSpeed'],
                $payload['characterImg']
            )
        );

        return $this->createApiResponse($this->createURL($id), Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
            CharacterAlreadyExists::class => Response::HTTP_BAD_REQUEST,
            CampaignDoesNotExist::class => Response::HTTP_BAD_REQUEST,
        ];
    }

    private function createURL(string $id): string
    {
        return sprintf(
            self::API_URL,
            $id
        );
    }
}
