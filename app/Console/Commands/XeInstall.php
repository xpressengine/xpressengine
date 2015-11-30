<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\Console\Question\Question;
use PDO;
use Symfony\Component\Process\Process;
use Xpressengine\Member\MemberHandler;
use Illuminate\Contracts\Auth\Guard;
use Xpressengine\Support\Migration;
use Symfony\Component\Yaml\Yaml;

class XeInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xe:install {--config= : Prepared file for configure}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xpressengine installation';

    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var bool
     */
    protected $executed = false;

    /**
     * @var array
     */
    protected $basePlugins = [
        'alice',
        'board',
        'ckeditor',
        'ckeditor_plugin',
        'claim',
        'comment_service',
        'page',
        'short_id_generator',
    ];

    /**
     * @var
     */
    protected $migrations;

    /**
     * @var
     */
    protected $env;

    /**
     * @var null|string
     */
    private $configFile;

    /**
     * @var array
     */
    protected $defaultInfos = [
        'site' => [
            'url' => 'http://localhost',
            'timezone' => 'Asia/Seoul',
        ],
        'admin' => [
            'email' => null,
            'password' => null,
            'displayName' => 'admin',
        ],
        'database' => [
            'host' => 'localhost',
            'dbname' => null,
            'port' => '3306',
            'username' => 'root',
            'password' => null,
        ],
    ];
    /**
     * @var bool
     */
    private $noInteraction = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command
     *
     * @return mixed
     */
    public function handle()
    {
        $noInteraction = $this->option('no-interaction');
        $configFile = $this->option('config');

        if ($configFile !== null && realpath($configFile) !== false) {
            $this->configFile = realpath($configFile);
            $config = Yaml::parse(file_get_contents($this->configFile));
            if ($config !== null) {
                $this->defaultInfos = array_merge($this->defaultInfos, $config);
            }

            // configFile 있을 경우에만 noInteraction 가능
            $this->noInteraction = $noInteraction;
        }

        $this->env = $this->getDefaultEnv();

        $this->process();
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param string $question
     * @param bool   $fallback
     * @param string $default
     * @return string
     */
    public function secretDefault($question, $fallback = true, $default = null)
    {
        $question = new Question($question, $default);

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }

    /**
     * Prompt the user for input and validation the answer.
     *
     * @param string  $question
     * @param string  $default
     * @param \Closure
     * @return string
     */
    public function askValidation($question, $default = null, \Closure $validator = null)
    {
        $question = new Question($question, $default);

        $question->setValidator($validator)->setMaxAttempts(null);

        return $this->output->askQuestion($question);
    }

    /**
     * getDefaultEnv
     *
     * @return string
     */
    protected function getDefaultEnv()
    {
        return "APP_ENV=local
APP_DEBUG=true
APP_KEY=SomeRandomString
APP_URL=http://localhost
APP_TIMEZONE=Asia/Seoul

DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
DB_PORT=3306

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME=null";
    }

    /**
     * process
     *
     * @return void
     */
    protected function process()
    {
        // get db info
        $this->getDBInfo();

        // validate db info
        $this->validateDBInfo($this->defaultInfos['database']);

        // set db info
        $this->setDBInfo($this->defaultInfos['database']);

        // get site info
        $this->getSiteInfo();

        // set site info
        $this->setSiteInfo($this->defaultInfos['site']);


        // load framework, migrations, installPlugin, run composer post script
        $this->installFramework();


        // create admin and login
        $this->getAdminInfo();
        $this->createAdminAndLogin($this->defaultInfos['admin']);

        // make welcomepage
        $this->initializeCore();

        $this->disableDebugMode();

        // change directory permissions
        $this->setStorageDirectoryPermission();

        $this->markInstalled();

        $this->line('Install was completed successfully.' . PHP_EOL);
    }

    /**
     * getDBInfo
     *
     * @return void
     */
    private function getDBInfo()
    {
        $this->info('[Setup Database(MySQL)]');

        if ($this->noInteraction) {
            $this->line('passed');
            return;
        }

        $this->line('Input Database Information.');

        $dbInfo = $this->defaultInfos['database'];

        // host
        $dbInfo['host'] = $this->ask("Host", $dbInfo['host']);

        // port
        $dbInfo['port'] = $this->ask("Port", $dbInfo['port']);

        // dbname
        $dbInfo['dbname'] = $this->ask("Database name", $dbInfo['dbname']);

        // username
        $dbInfo['username'] = $this->ask("UserID", $dbInfo['username']);

        // password
        $default = '';
        if (isset($dbInfo['password']) && $dbInfo['password'] !== null) {
            $default = 'imported from config file';
        }
        $password = $this->secretDefault("Password", false, $default);
        if (!$password || $password == $default) {
            $password = $dbInfo['password'];
        }
        $dbInfo['password'] = $password;

        $this->defaultInfos['database'] = $dbInfo;
    }

    /**
     * validateDBInfo

     * @param                 $dbInfo
     *
     * @return bool
     * @throws \Exception
     */
    private function validateDBInfo($dbInfo)
    {
        $this->info('[Checking Database Connection]');
        $this->line('Connecting Database using inputted database information..');

        try {
            $dsn = 'mysql:host='.$dbInfo['host'].';dbname='.$dbInfo['dbname'];
            if ($dbInfo['port']) {
                $dsn .= ";port=".$dbInfo['port'];
            }

            $db = new PDO(
                $dsn, $dbInfo['username'], $dbInfo['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            // check table count
            $stmt = $db->query(
                "SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = '{$dbInfo['dbname']}'"
            );
            $result = $stmt->fetch();
            $count = $result['cnt'];
        } catch (\Exception $e) {
            $this->error('Connection failed!!');
            throw $e;
        }

        if ($count !== '0') {
            $message = "database {$dbInfo['dbname']} is not empty. Please drop all tables in {$dbInfo['dbname']}";
            $this->error($message);
            throw new \Exception($message);
        }

        $this->line('Connection successful.');
        return true;
    }

    /**
     * setDBInfo
     *
     * @param $dbInfo
     *
     * @return void
     */
    private function setDBInfo($dbInfo)
    {

        $defaults = [
            'DB_HOST' => 'localhost',
            'DB_PORT' => '3306',
            'DB_DATABASE' => 'homestead',
            'DB_USERNAME' => 'homestead',
            'DB_PASSWORD' => 'secret',
        ];

        $values = [
            'DB_HOST' => $dbInfo['host'],
            'DB_PORT' => $dbInfo['port'],
            'DB_DATABASE' => $dbInfo['dbname'],
            'DB_USERNAME' => $dbInfo['username'],
            'DB_PASSWORD' => $dbInfo['password'],
        ];

        foreach ($values as $key => $value) {
            $this->setEnv($key, $value, $defaults[$key]);
        }
    }

    /**
     * setEnv
     *
     * @param        $key
     * @param        $newValue
     * @param string $defaultValue
     *
     * @return void
     */
    protected function setEnv($key, $newValue, $defaultValue = '')
    {
        $this->env = str_replace("$key=".$defaultValue, "$key=".$newValue, $this->env);
    }

    /**
     * getSiteInfo
     *
     * @return void
     */
    private function getSiteInfo()
    {
        $this->info('[Setup Site]');

        if ($this->noInteraction) {
            $this->line('passed');
            return;
        }

        $this->line('Input information for site.');

        $siteInfo = $this->defaultInfos['site'];

        // site url
        $siteInfo['url'] = $this->askValidation('site url', $siteInfo['url'], function ($url) {
            if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                throw new \Exception('Invalid URL Format.');
            }
            return $url;
        });

        // timezone
        $siteInfo['timezone'] = $this->askValidation('Timezone', $siteInfo['timezone'], function ($timezone) {
            if (in_array($timezone, timezone_identifiers_list()) === false) {
                throw new \Exception('Inputted timezone do not exist.');
            }

            return $timezone;
        });

        $this->defaultInfos['site'] = $siteInfo;
    }

    /**
     * setSiteInfo
     *
     * @param $siteInfo
     *
     * @return void
     */
    private function setSiteInfo($siteInfo)
    {
        $this->setEnv('APP_URL', $siteInfo['url'], 'http://localhost');
        $this->setEnv('APP_TIMEZONE', $siteInfo['timezone'], 'Asia/Seoul');
    }

    /**
     * installFramework
     *
     * @return void
     */
    protected function installFramework()
    {
        $this->info('[Base Framework load]');
        $this->line('Base Framework is loading...');

        $this->writeEnvFile();
        // reboot for load env file
        $this->bootFramework();

        // migration
        // 각 패키지마다 필요한 database table을 생성하고, seeding
        // 필요한 directory와 file을 생성한다.
        $this->migrateCore();

        // plugin 설치를 위해 core service 를 load 하기 위한 reboot
        // booting framework with xpressengine service providers
        $this->bootFramework(true);

        // install and activate default plugins
        $this->installBasePlugins();

        // plugin 의 menu 생성 작업을 위한 reboot
        // booting framework with xpressengine service providers
        $this->bootFramework(true);

        // composer의 post script를 run한다.
        // script - optimizing & key generation
        $this->runPostScript();

        $this->line("Base Framework is loaded\n");
    }

    /**
     * writeEnvFile
     *
     * @return void
     */
    private function writeEnvFile()
    {
        $path = $this->getBasePath('.env');
        file_put_contents($path, $this->env);
    }

    /**
     * basePath
     *
     * @param null $path
     *
     * @return string
     */
    private function getBasePath($path = null)
    {
        return base_path($path);
    }

    /**
     * bootFramework
     *
     * @param bool $withXE
     *
     * @return mixed
     * @throws \Exception
     */
    private function bootFramework($withXE = false)
    {
        require $this->getBasePath('vendor/autoload.php');

        $appFile = $this->getBasePath('bootstrap/app.php');
        if (!file_exists($appFile)) {
            throw new \Exception('Unable to find app loader: ~/bootstrap/app.php');
        }

        $app = include($appFile);

//        $app = app();

        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
        if ($withXE) {
            $kernel->bootstrap(true);
        } else {
            $kernel->bootstrap();
        }

        return $app;
    }

    /**
     * migrateCore
     *
     * @return void
     */
    private function migrateCore()
    {
        /** @var Filesystem $filesystem */
        $filesystem = app('files');
        $files = $filesystem->files(base_path('migrations'));

        foreach ($files as $file) {
            $class = "\\Xpressengine\\Migrations\\".basename($file, '.php');
            $this->migrations[] = $migration = new $class();
            /** @var Migration $migration */
            $migration->install();
        }

        foreach ($this->migrations as $migration) {
            if (method_exists($migration, 'installed')) {
                $migration->installed();
            }
        }
    }

    /**
     * installBasePlugins
     *
     * @return void
     */
    private function installBasePlugins()
    {
        $plugins = $this->basePlugins;

        foreach ($plugins as $plugin) {
            \Plugin::activatePlugin($plugin);
        }
    }

    /**
     * runPostScript
     *
     * @return void
     */
    private function runPostScript()
    {
        $composer = $this->findComposer();
        $commands = [
            $composer.' run-script post-install-cmd',
            $composer.' run-script post-create-project-cmd',
        ];

        $process = new Process(implode(' && ', $commands), $this->getBasePath(), null, null, null);

        $process->run(
            function ($type, $line) {
                $this->line($line);
            }
        );
    }

    /**
     * findComposer
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar';
        }

        return 'composer';
    }

    /**
     * getAdminInfo
     *
     * @return void
     */
    private function getAdminInfo()
    {
        $this->info('[Setup Admin information]');

        if ($this->noInteraction) {
            $this->line("passed");
            return;
        }

        $this->line("Input information for site admin.");

        $adminInfo = $this->defaultInfos['admin'];

        // email
        $adminInfo['email'] = $this->askValidation('Email', $adminInfo['email'], function ($email) {
            $validate = \Validator::make(
                ['email' => $email],
                [
                    'email' => 'email'
                ]
            );
            if ($validate->fails()) {
                throw new \Exception('Invalid Email address.');
            }
            return $email;
        });

        // displayName
        $adminInfo['displayName'] = $this->askValidation('Name', $adminInfo['displayName'], function ($displayName) {
            if (strlen(trim($displayName)) === 0) {
                throw new \Exception('Input Name');
            }
            return $displayName;
        });

        // password
        $default = '';
        if (isset($adminInfo['password']) && $adminInfo['password'] !== null) {
            $default = 'imported from config file';
        }
        $password = $this->secretDefault("Password", false, $default);
        if (!$password || $password == $default) {
            $password = $adminInfo['password'];
        }
        $adminInfo['password'] = $password;

        $this->defaultInfos['admin'] = $adminInfo;
    }

    /**
     * createAdminAndLogin
     *
     * @param $config
     *
     * @return void
     */
    protected function createAdminAndLogin($config)
    {
        $config['rating'] = 'super';
        $config['status'] = 'activated';
        $config['emailConfirmed'] = true;

        // create admin account
        /** @var MemberHandler $memberHandler */
        $memberHandler = app('xe.member');
        $admin = $memberHandler->create($config);

        $this->env = file_get_contents($this->getBasePath('.env'));

        $this->setEnv('MAIL_FROM_ADDRESS', $config['email'], 'null');
        $this->setEnv('MAIL_FROM_NAME', $config['displayName'], 'null');
        $this->writeEnvFile();

        // login admin
        /** @var Guard $auth */
        $auth = app('auth');
        $auth->login($admin);
    }

    /**
     * disableDebugMode
     *
     * @return void
     */
    private function disableDebugMode()
    {
        // for sync APP_KEY
        $this->env = file_get_contents($this->getBasePath('.env'));

        $this->setEnv('APP_DEBUG', 'false', 'true');
        $this->writeEnvFile();
    }

    /**
     * initializeCore
     *
     * @return void
     */
    private function initializeCore()
    {
        foreach ($this->migrations as $migration) {
            if (method_exists($migration, 'init')) {
                $migration->init();
            }
        }
    }

    /**
     * setStorageDirectoryPermission
     *
     * @return void
     */
    private function setStorageDirectoryPermission()
    {
        $this->info('[Setup Directory Permission]');

        $path = $this->getBasePath('storage');
        $permission = '0707';

        if (!$this->noInteraction) {
            $this->line('Input directory permission for storage.');

            $permission = $this->ask('./storage directory permission', '0707');
        } else {
            $this->line("passed");
        }

        $process = new Process("chmod -R $permission $path");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    private function markInstalled()
    {
        $markFile = $path = $this->getBasePath('storage/app/installed');
        touch($markFile);
    }
}
