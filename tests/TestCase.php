<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * После bootstrap принудительно используем in-memory SQLite, чтобы тесты не зависели от MySQL из .env / config cache.
     */
    public function createApplication(): Application
    {
        $base = Application::inferBasePath();
        foreach (glob($base.'/bootstrap/cache/routes-*.php') ?: [] as $cachedRoutes) {
            if (is_file($cachedRoutes)) {
                @unlink($cachedRoutes);
            }
        }

        $app = parent::createApplication();

        $key = $app['config']->get('app.key');
        if ($key === null || $key === '') {
            $app['config']->set('app.key', 'base64:2fl+KtvkDFZNCSl8goKyYl+wG5/NlJ6f+2h/WK+Z1j4=');
        }

        if (extension_loaded('pdo_sqlite')) {
            $app['config']->set('database.default', 'sqlite');
            $app['config']->set('database.connections.sqlite.database', ':memory:');
            if ($app->bound('db')) {
                $app['db']->purge();
            }
        }

        return $app;
    }
}
