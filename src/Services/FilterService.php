<?php

namespace App\Services;

use Nette\Utils\Strings;

class FilterService
{
    /**
     * @param string $content
     * @param string $pattern
     * @return array<string, int>
     */
    public static function filter(string $content, string $pattern): array
    {
        $result = [];

        foreach (Strings::split($content, "/" . PHP_EOL . "/") as $line) {
            $category = self::matchCategory($line, $pattern);
            self::incrementCategory($category, $result);
        }
        ksort($result);
        return $result;
    }

    private static function matchCategory(string $line, string $pattern): ?string
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
