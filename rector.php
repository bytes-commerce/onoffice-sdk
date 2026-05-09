<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        SetList::PHP_84,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
    ])
    ->withSkip([
        '*/var/*',
        '*/vendor/*',
        '*/node_modules/*',
        '*/migrations/*',
        '*/.phpunit.cache/*',
    ])
    ->withCache(__DIR__ . '/var/cache/rector')
    ->withParallel()
    ->withImportNames(removeUnusedImports: true);
