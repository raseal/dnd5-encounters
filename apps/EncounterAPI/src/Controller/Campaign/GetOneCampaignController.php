<?php

declare(strict_types=1);

namespace EncounterAPI\Controller\Campaign;

use Encounter\Campaign\Application\GetOneCampaign\GetOneCampaignQuery;
use Encounter\Campaign\Domain\Exception\CampaignDoesNotExist;
use Shared\Domain\Exception\InvalidUuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetOneCampaignController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $response = $this->ask(
            new GetOneCampaignQuery(
                $request->attributes->get('id')
            )
        );

        return $this->createApiResponse($response);
    }

    protected function exceptions(): array
    {
        return [
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
            CampaignDoesNotExist::class => Response::HTTP_NOT_FOUND
        ];
    }
}
