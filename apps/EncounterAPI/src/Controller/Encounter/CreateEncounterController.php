<?php

declare(strict_types=1);

namespace EncounterAPI\Controller\Encounter;

use Encounter\Character\Domain\Exception\CampaignDoesNotExist;
use Encounter\Character\Domain\Exception\CharacterDoesNotBelongToCampaign;
use Encounter\Character\Domain\Exception\CharacterDoesNotExist;
use Encounter\Encounter\Application\Create\CreateEncounterCommand;
use Encounter\Encounter\Domain\Exception\EncounterAlreadyExists;
use Encounter\Encounter\Domain\Exception\InvalidEncounterDifficulty;
use Encounter\Monster\Domain\Exception\InvalidMonsterSize;
use Encounter\Monster\Domain\Exception\InvalidSourceBook;
use Shared\Domain\Exception\InvalidPositiveInteger;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function sprintf;

final class CreateEncounterController extends ApiController
{
    const API_URL = 'encounters/%s';

    public function __invoke(Request $request)
    {
        $id = Uuid::random()->value();
        $payload = $this->getPayload($request);

        $this->dispatch(
            new CreateEncounterCommand(
                $id,
                $payload['campaignId'],
                false,
                $payload['monsters'],
                $payload['playersIds'],
                $payload['encounterName'],
                0,
                0
            )
        );

        return $this->createApiResponse($this->createURL($id), Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [
            InvalidSourceBook::class => Response::HTTP_BAD_REQUEST,
            InvalidMonsterSize::class => Response::HTTP_BAD_REQUEST,
            InvalidPositiveInteger::class => Response::HTTP_BAD_REQUEST,
            CampaignDoesNotExist::class => Response::HTTP_BAD_REQUEST,
            EncounterAlreadyExists::class => Response::HTTP_BAD_REQUEST,
            CharacterDoesNotExist::class => Response::HTTP_BAD_REQUEST,
            CharacterDoesNotBelongToCampaign::class => Response::HTTP_BAD_REQUEST,
            InvalidEncounterDifficulty::class => Response::HTTP_INTERNAL_SERVER_ERROR,
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
