<?php

declare(strict_types=1);

namespace Bow\Database;

use Bow\Configuration\Configuration;
use Bow\Configuration\Loader;

class DatabaseConfiguration extends Configuration
{
    /**
     * @inheritdoc
     */
    public function create(Loader $config): void
    {
        $this->container->bind('db', function () use ($config) {
            return Database::configure($config['database'] ?? $config['db']);
        });
    }

    /**
     * @inheritdoc
     */
    public function run(): void
    {
        $this->container->make('db');
    }
}
