<?php

declare(strict_types=1);

namespace EncounterAPI\Controller\Character;

use Encounter\Character\Application\GetOneCharacter\GetOneCharacterQuery;
use Encounter\Character\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;
use Shared\Domain\Exception\InvalidUuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOneCharacterController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $response = $this->ask(
            new GetOneCharacterQuery(
                $request->attributes->get('id')
            )
        );

        return $this->createApiResponse($response);
    }

    protected function exceptions(): array
    {
        return [
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
            CharacterDoesNotExist::class => Response::HTTP_NOT_FOUND,
            CampaignDoesNotExist::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
