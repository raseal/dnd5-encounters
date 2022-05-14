<?php

declare(strict_types=1);

namespace EncounterAPI\Controller\Monster;

use Encounter\Monster\Application\Search\SearchMonstersQuery;
use Shared\Domain\Criteria\Filter\Exception\InvalidFilter;
use Shared\Domain\Criteria\Filter\Exception\InvalidOperator;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SearchMonstersController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $response = $this->ask(
            new SearchMonstersQuery(
                $request->query->all('filter'),
                (int) $request->get('page'),
                (int) $request->get('limit')
            )
        );

        return $this->createApiResponse($response);
    }

    protected function exceptions(): array
    {
        return [
            InvalidFilter::class => Response::HTTP_BAD_REQUEST,
            InvalidOperator::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
