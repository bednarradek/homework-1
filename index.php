<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Commands\FilterCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new FilterCommand());
$application->run();