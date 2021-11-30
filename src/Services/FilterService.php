<?php

namespace App\Services;

use Generator;
use Nette\Utils\Strings;

class FilterService
{
    /**
     * @param string $path
     * @return Generator<int, string>
     */
    protected static function getFileLines(string $path): Generator
    {
        $file = fopen($path, 'r');
        if ($file) {
            while ($line = fgets($file)) {
                yield $line;
            }
            fclose($file);
        }
    }

    /**
     * @param string $path
     * @param string $pattern
     * @return array<string, int>
     */
    public static function filterFile(string $path, string $pattern): array
    {
        $result = [];

        foreach (self::getFileLines($path) as $line) {
            if (is_string($line)) {
                $category = self::matchCategory($line, $pattern);
                self::incrementCategory($category, $result);
            }
        }
        ksort($result);
        return $result;
    }

    public static function matchCategory(string $line, string $pattern): ?string
    {
        $category = Strings::match($line, $pattern)[1] ?? null;
        return $category ? Strings::upper($category) : null;
    }

    /**
     * @param string|null $category
     * @param array<string, int> $result
     */
    private static function incrementCategory(?string $category, array &$result): void
    {
        if ($category) {
            isset($result[$category]) ? $result[$category]++ : $result[$category] = 1;
        }
    }
}
