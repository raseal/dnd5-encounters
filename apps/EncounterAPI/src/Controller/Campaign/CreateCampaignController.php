<?php

declare(strict_types=1);

namespace EncounterAPI\Controller\Campaign;

use Encounter\Campaign\Application\Create\CreateCampaignCommand;
use Encounter\Campaign\Domain\Exception\CampaignAlreadyExists;
use Shared\Domain\Exception\InvalidUuid;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function sprintf;

final class CreateCampaignController extends ApiController
{
    const API_URL = 'campaigns/%s';

    public function __invoke(Request $request): Response
    {
        $id = Uuid::random()->value();
        $payload = $this->getPayload($request);

        $this->dispatch(
            new CreateCampaignCommand(
                $id,
                $payload['campaignName'],
                (bool) $payload['campaignActive']
            )
        );

        return $this->createApiResponse($this->createURL($id), Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
            CampaignAlreadyExists::class => Response::HTTP_BAD_REQUEST
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
