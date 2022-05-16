<?php

declare(strict_types=1);

namespace Encounter\Campaign\Infrastructure\Persistence;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Encounter\Campaign\Domain\Campaign;
use Encounter\Campaign\Domain\CampaignActive;
use Encounter\Campaign\Domain\CampaignId;
use Encounter\Campaign\Domain\CampaignName;
use Encounter\Campaign\Domain\CampaignRepository;

final class DBALCampaignRepository implements CampaignRepository
{
    public function __construct(
        private Connection $connection
    ) {}

    public function save(Campaign $campaign): void
    {
        $queryBuilder = new QueryBuilder($this->connection);
        $queryBuilder
            ->insert('campaign')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'active' => ':active',
            ])
            ->setParameters([
                'id' => $campaign->campaignId()->value(),
                'name' => $campaign->campaignName()->value(),
                'active' => (int) $campaign->campaignActive()->value(),
            ])
            ->executeQuery();
    }

    public function findById(CampaignId $campaignId): ?Campaign
    {
        $qb = new QueryBuilder($this->connection);
        $result = $qb
            ->select('id, name, active')
            ->from('campaign')
            ->where('id = :id')
            ->setParameter('id', $campaignId->value())
            ->executeQuery();

        if (0 === $result->rowCount()) {
            return null;
        }

        $data = $result->fetchAssociative();

        return new Campaign(
            new CampaignId($data['id']),
            new CampaignName($data['name']),
            new CampaignActive((bool) $data['active'])
        );
    }
}
