<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder(
        Finder::create()
            ->in([
                __DIR__.'/src',
                __DIR__.'/tests',
                __DIR__.'/config',
                __DIR__.'/public',
                __DIR__.'/migrations',
            ])
    );
