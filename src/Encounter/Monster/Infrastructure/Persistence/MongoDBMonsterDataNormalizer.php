<?php

declare(strict_types=1);

namespace Encounter\Monster\Infrastructure\Persistence;

use function array_shift;
use function gettype;
use function implode;
use function sprintf;
use function substr;

final class MongoDBMonsterDataNormalizer
{
    private const TOKEN_URL_PATTERN = 'https://5e.tools/img/%s/%s.png';

    public static function normalize(array $monsterData): array
    {
        return [
            'name' => $monsterData['name'],
            'size' => self::parseSize($monsterData),
            'type' => self::parseType($monsterData),
            'tokenURL' => self::tokenURL($monsterData),
            'source' => $monsterData['source'],
            'page' => $monsterData['page'],
            'ac' => self::parseArmorClass($monsterData),
            'hp' => self::parseHP($monsterData),
            'speed' => self::parseSpeed($monsterData),
            'str' => $monsterData['str'],
            'dex' => $monsterData['dex'],
            'con' => $monsterData['con'],
            'int' => $monsterData['int'],
            'wis' => $monsterData['wis'],
            'cha' => $monsterData['cha'],
            'savings' => self::parseSavings($monsterData),
            'skills' => self::parseSkills($monsterData),
            'senses' => self::parseSenses($monsterData),
            'immunities' => self::parseImmunities($monsterData),
            'cr' => self::parseChallengeRate($monsterData),
            'actions' => self::parseActions($monsterData),
            'traits' => self::parseTraits($monsterData),
            'legendaryActions' => self::parseLegendaryActions($monsterData),
        ];
    }

    private static function parseSize(array $data): string
    {
        return self::implodeNoKeys($data['size']);
    }

    private static function parseType(array $data): string
    {
        return 'object' === gettype($data['type']) ? $data['type']->type : $data['type'];
    }

    private static function tokenURL(array $data): string
    {
        return sprintf(
            self::TOKEN_URL_PATTERN,
            $data['source'],
            $data['name']
        );
    }

    private static function parseArmorClass(array $data): int
    {
        return 'object' === gettype($data['ac'][0]) ? ((array) $data['ac'][0])['ac'] : $data['ac'][0];
    }

    private static function parseHP(array $data): array
    {
        return (array) $data['hp'];
    }

    private static function parseSpeed(array $data): string
    {
        return self::implodeWithKeys((array) $data['speed']);
    }

    private static function parseSavings(array $data): ?string
    {
        return empty($data['save']) ? null : self::implodeWithKeys((array) $data['save']);
    }

    private static function parseSkills(array $data): ?string
    {
        return empty($data['skill']) ? null : self::implodeWithKeys((array) $data['skill']);
    }

    private static function parseSenses(array $data): ?string
    {
        return empty($data['senses']) ? null : self::implodeNoKeys((array)$data['senses']);
    }

    private static function parseImmunities(array $data): ?string
    {
        if (empty($data['immune'])) {
            return null;
        }

        $result = '';

        foreach ($data['immune'] as $immunity) {
            if ('string' === gettype($immunity))
                $result .= $immunity.', ';
        }

        return $result;
    }

    private static function parseChallengeRate(array $data): string
    {
        if ('object' === gettype($data['cr'])) {
            return $data['cr']->cr;
        }

        return $data['cr'];
    }

    private static function parseActions(array $data): ?array
    {
        if (empty($data['action'])) {
            return null;
        }

        $parsedActions = [];

        foreach($data['action'] as $i => $action) {
            $parsedActions[$i][$action->name]['description'] = array_shift($action->entries);

            foreach ($action->entries as $additionalAction) {
                if ('string' === gettype($additionalAction) ) {
                    $parsedActions[$i][$action->name]['description'].= " ".$additionalAction;
                } else if(isset($additionalAction->items)) {
                    foreach ($additionalAction->items as $item) {
                        $parsedActions[$i][$action->name][$item->name] = $item->entry ?? $item->entries;
                    }
                }
            }
        }

        return $parsedActions;
    }

    private static function parseTraits(array $data): ?array
    {
        if (empty($data['trait'])) {
            return null;
        }

        $traits = [];

        foreach ($data['trait'] as $trait) {
            if (1 === count($trait->entries)) {
                $traits[$trait->name] = implode($trait->entries);
            }
        }

        return $traits;
    }

    private static function parseLegendaryActions(array $data): ?array
    {
        if (empty($data['legendary'])) {
            return null;
        }

        $actions = [];

        foreach ($data['legendary'] as $action) {
            $actions[$action->name] = implode($action->entries);
        }

        return $actions;
    }

    private static function implodeNoKeys(array $data, string $separator = ', '): string
    {
        return implode($separator, $data);
    }

    private static function implodeWithKeys(array $data): string
    {
        $text = '';

        foreach ($data as $key => $value) {
            if ('object' !== gettype($value)) {
                $text .= $key . ' ' . $value . ', ';
            }
        }

        return substr($text, 0, -2);
    }
}
