<?php

declare(strict_types=1);

namespace EncounterAPI\CLI;

use MongoDB\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function file_get_contents;
use function json_decode;

final class DataloaderCLI extends Command
{
    protected static $defaultName = "dataloader:load";
    private const LOCATION_DATA = __DIR__.'/../../../../data/';

    private const MONSTER = 'monster';
    private const MONSTER_FILES = [
       'bestiary-bgdia.json',
       'bestiary-dmg.json',
       'bestiary-ftd.json',
       'bestiary-mm.json',
       'bestiary-phb.json',
       'bestiary-tce.json',
       'bestiary-xge.json',
    ];

    private const EXTRA = 'extra';
    private const EXTRA_FILES = [
        'condition' => 'conditionsdiseases.json',
        'disease' => 'conditionsdiseases.json',
        'status' => 'conditionsdiseases.json',
        'legendaryGroup' => 'legendarygroups.json',
        'book' => 'sourcebooks.json',
    ];

    private const SPELL = 'spell';
    private const SPELL_FILES = [
        'spells-ftd.json',
        'spells-phb.json',
        'spells-tce.json',
        'spells-xge.json',
    ];

    public function __construct(
        private Client $client,
        private string $mongoDBEncounters
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Parse the json files located at `data` dir and dumps into MongoDB.');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->client->dropDatabase($this->mongoDBEncounters);

        $output->writeln('<info>Loading extra data...</info>');
        $this->loadExtraData();

        $output->writeln('<info>Loading bestiary...</info>');
        $this->loadBestiary();

        $output->writeln('<info>Loading spells...</info>');
        $this->loadSpells();

        return self::SUCCESS;
    }

    private function loadExtraData(): void
    {
        $location = $this->getFilesDir(self::EXTRA);

        foreach (self::EXTRA_FILES as $collectionName => $jsonFile) {
            $json = $this->dataAsJsonArray($location.'/'.$jsonFile);
            $collection = $this->client->selectCollection($this->mongoDBEncounters, $collectionName);
            $collection->insertMany($json[$collectionName]);
        }
    }

    private function loadBestiary(): void
    {
        $this->load(self::MONSTER, self::MONSTER_FILES);
    }

    private function loadSpells(): void
    {
        $this->load(self::SPELL, self::SPELL_FILES);
    }

    private function load(string $collectionName, array $files): void
    {
        $location = $this->getFilesDir($collectionName);
        $collection = $this->client->selectCollection($this->mongoDBEncounters, $collectionName);

        foreach ($files as $jsonFile) {
            $json = $this->dataAsJsonArray($location.'/'.$jsonFile);
            $collection->insertMany($json[$collectionName]);
        }
    }

    private function dataAsJsonArray(string $pathJsonFile): array
    {
        $data = file_get_contents($pathJsonFile);

        return json_decode($data, true);
    }

    private function getFilesDir(string $folder): string
    {
        return self::LOCATION_DATA . $folder;
    }
}
