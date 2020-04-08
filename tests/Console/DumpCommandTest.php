<?php

declare(strict_types=1);

namespace Ngmy\LaravelMysqlDumper\Tests\Console;

use Illuminate\Testing\PendingCommand;
use Ngmy\LaravelMysqlDumper\Tests\TestCase;

class DumpCommandTest extends TestCase
{
    /**
     * @return void
     */
    public function testDumpWithDefaultSetting(): void
    {
        $default = $this->app->make('config')->get('ngmy-mysql-dumper.default');
        $setting = $this->app->make('config')->get('ngmy-mysql-dumper.settings.' . $default);
        $resultFile = $setting['result_file'];

        $this->addDumpFile($resultFile);

        $command = $this->artisan('mysql-dumper:dump');

        assert($command instanceof PendingCommand);

        $command->run();

        $this->assertFileExists($resultFile);
    }
}
