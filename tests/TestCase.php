<?php

declare(strict_types=1);

namespace Ngmy\LaravelMysqlDumper\Tests;

use File;
use Ngmy\LaravelMysqlDumper\MysqlDumperServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /** @var array<int, string> */
    private $dumpFiles = [];

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->clearDumpFiles();

        parent::tearDown();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array<int, string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            MysqlDumperServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app->make('config')->set('database.default', 'mysql');
    }

    /**
     * @param string $path
     * @return void
     */
    protected function clearDumpFile(string $path): void
    {
        File::delete($path);
    }

    /**
     * @return void
     */
    protected function clearDumpFiles(): void
    {
        if (empty($this->dumpFiles)) {
            return;
        }

        foreach ($this->dumpFiles as $dumpFile) {
            $this->clearDumpFile($dumpFile);
        }
    }

    /**
     * @param string $dumpFile
     * @return void
     */
    protected function addDumpFile(string $dumpFile): void
    {
        $this->dumpFiles[] = $dumpFile;
    }
}
