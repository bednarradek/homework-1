<?php

declare(strict_types=1);

namespace App\Commands;

use App\Services\FilterService;
use Nette\Utils\FileSystem;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FilterCommand extends Command
{
    private const PATTERN = "^.*test\.(.*):.*$";

    protected static $defaultName = 'app:filter';
    protected const INFINITY_STREAM = 'Infinity stream';
    protected const FILE_INPUT = 'File input';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputAnswer = $io->choice("Infinity stream or file input?", [self::INFINITY_STREAM, self::FILE_INPUT]);

        if ($inputAnswer === self::FILE_INPUT) {
            $path = $io->ask("Write file path", '', function ($path) {
                if (!is_file($path)) {
                    throw new RuntimeException("'{$path}' is not valid file");
                }
                return $path;
            });

            $pattern = $this->patternAsk($io);

            $path = strval($path);
            $result = FilterService::filter(FileSystem::read($path), '/' . $pattern . '/');
            $this->printResult($result, $io);
        } else {
            $content = "";
            $pattern = $this->patternAsk($io);

            while (($input = $io->ask("Write input", '')) !== '') {
                $content .= $input . PHP_EOL;
                $result = FilterService::filter($content, '/' . $pattern . '/');
                $this->printResult($result, $io);
            }
        }

        return Command::SUCCESS;
    }

    protected function patternAsk(SymfonyStyle $io): string
    {
        $pattern = $io->ask(
            "Define patter for filter",
            self::PATTERN
        );
        return strval($pattern);
    }

    /**
     * @param array<string, int> $result
     * @param SymfonyStyle $io
     */
    protected function printResult(array $result, SymfonyStyle $io): void
    {
        $io->table(array_keys($result), [array_values($result)]);
    }
}
