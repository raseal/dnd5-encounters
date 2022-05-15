<?php

declare(strict_types=1);

namespace Test;

use MongoDB\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MongoDBTestCase extends KernelTestCase
{
    protected const TEST_DATABASE = 'dnd5_encountersTest';
    protected const TEST_COLLECTION = 'monster';

    public function client(): Client
    {
        return $this->getContainer()->get(Client::class);
    }

    protected function tearDown(): void
    {
        $this->client()->dropDatabase(self::TEST_DATABASE);
    }

    protected function saveSingleRecord(array $record): void
    {
        $this->client()
            ->selectCollection(self::TEST_DATABASE, self::TEST_COLLECTION)
            ->insertOne($record);
    }
}
