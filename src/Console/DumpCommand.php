<?php

declare(strict_types=1);

namespace Ngmy\LaravelMysqlDumper\Console;

use DB;
use Ifsnop\Mysqldump\Mysqldump;
use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\MySqlConnection;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class DumpCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mysql-dumper:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump the MySQL database';

    /** @var Repository */
    private $config;

    /**
     * Create a new command instance.
     *
     * @param Repository $config
     * @return void
     */
    public function __construct(Repository $config)
    {
        parent::__construct();

        $this->config = $config;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $settingName = $this->option('setting') ?? $this->config->get('ngmy-mysql-dumper.default');
        $this->dump($settingName);
    }

    /**
     * @param string $settingName
     * @return void
     */
    public function dump(string $settingName): void
    {
        $setting = $this->config->get('ngmy-mysql-dumper.settings.' . $settingName);
        $connectionName = $setting['connection'] ?? $this->config->get('database.default');
        $dumpOptions = $setting['dump_options'] ?? [];
        $resultFile = $setting['result_file'] ?? \database_path('dump.sql');
        $importableWithLaravel = $setting['importable_with_laravel'] ?? false;

        $connection = DB::connection($connectionName);

        if (!$connection instanceof MySqlConnection) {
            throw new InvalidArgumentException(
                'This command only supports MySQL.' . PHP_EOL .
                'Connection name: ' . $connection->getName() . PHP_EOL .
                'Driver name: ' . $connection->getDriverName()
            );
        }

        $dbConfig = $connection->getConfig();

        $dumpOptions['default-character-set'] = $dumpOptions['default-character-set'] ?? $dbConfig['charset'];

        $dump = new Mysqldump(
            'mysql:host=' . $dbConfig['host'] . ';port=' . $dbConfig['port'] . ';dbname=' . $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dumpOptions
        );
        $dump->start($resultFile);

        if ($importableWithLaravel) {
            // HACK Remove the DELIMITER command because the DB::unprepared method doesn't understand
            exec('sed -i -E "
                s|DELIMITER ;;$||g;
                s|DELIMITER ;$||g;
                s|;;|;|g;
                " ' . $resultFile);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    protected function getOptions(): array
    {
        return [
            ['setting', null, InputOption::VALUE_OPTIONAL, 'The dump setting to use'],
        ];
    }
}
