<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'cache.stores.redis' => [
                'driver' => 'array',
                'serialize' => false,
            ],
        ]);
    }

    public function createApplication()
    {
        $this->clearBootstrapCaches();

        $app = require Application::inferBasePath().'/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function clearBootstrapCaches(): void
    {
        $cacheFiles = [
            Application::inferBasePath().'/bootstrap/cache/config.php',
            Application::inferBasePath().'/bootstrap/cache/events.php',
            Application::inferBasePath().'/bootstrap/cache/routes-v7.php',
        ];

        foreach ($cacheFiles as $cacheFile) {
            if (is_file($cacheFile)) {
                unlink($cacheFile);
            }
        }
    }
}
