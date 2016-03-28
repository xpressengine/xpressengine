<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Filesystem\Filesystem;
use PDO;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Yaml\Yaml;
use Xpressengine\Support\Migration;
use Xpressengine\User\UserHandler;

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
        'claim',
        'comment',
        'page',
        'news_client',
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
            'url' => 'http://mysite.com',
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
        return "APP_ENV=cms
APP_DEBUG=true
APP_KEY=SomeRandomString";
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
        $this->setDirectoryPermission();

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
        $default = false;
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
        $info = [
            'connections' => [
                'mysql' => [
                    'driver'    => 'mysql',
                    'host'      => $dbInfo['host'],
                    'database'  => $dbInfo['dbname'],
                    'username'  => $dbInfo['username'],
                    'password'  => $dbInfo['password'],
                    'port'      => $dbInfo['port'],
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix' => 'xe_',
                    'strict'    => false,
                ],
            ]
        ];

        $this->configFileGenerate('database', $info);
    }

    private function configFileGenerate($key, array $data)
    {
        $dir = config_path() . '/cms';
        $this->makeDir($dir);

        $data = $this->encodeArr2Str($data);

        $file = $dir . "/{$key}.php";
        file_put_contents($file, '<?php' . str_repeat(PHP_EOL, 2) . 'return [' . PHP_EOL . $data . '];' . PHP_EOL);
    }

    private function makeDir($dir)
    {
        /** @var Filesystem $filesystem */
        $filesystem = app('files');
        if (!$filesystem->isDirectory($dir)) {
            return $filesystem->makeDirectory($dir);
        }

        return true;
    }

    private function encodeArr2Str(array $arr, $depth = 0)
    {
        $output = '';

        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $output .= $this->getIndent($depth) . "'{$key}' => " . '[' . PHP_EOL . $this->encodeArr2Str($val, $depth + 1) . $this->getIndent($depth) . '],' . PHP_EOL;
            } else {
                $output .= $this->getIndent($depth) . "'{$key}' => " . (is_int($val) ? $val : "'{$val}'") .',' . PHP_EOL;
            }
        }

        return $output;
    }

    private function getIndent($depth)
    {
        $indent = '';
        for ($a = 0; $a <= $depth; $a++) {
            $indent .= str_repeat(' ', 4);
        }

        return $indent;
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
            $url = trim($url, "/");
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
        $info = [
            'url' => $siteInfo['url'],
            'timezone' => $siteInfo['timezone'],
        ];

        $this->configFileGenerate('app', $info);
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
            \XePlugin::activatePlugin($plugin);
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
     * Illuminate\Foundation\Composer
     *
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (!file_exists($this->getBasePath('composer.phar'))) {
            return 'composer';
        }

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

        if (defined('HHVM_VERSION')) {
            $binary .= ' --php';
        }

        return "{$binary} composer.phar";
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
        /** @var UserHandler $userHandler */
        $userHandler = app('xe.user');
        $admin = $userHandler->create($config);

        // create mail config
        $info = [
            'from' => [
                'address' => $config['email'],
                'name' => $config['displayName']
            ],
        ];
        $this->configFileGenerate('mail', $info);

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
     * setDirectoryPermission
     *
     * @return void
     */
    private function setDirectoryPermission()
    {
        $this->info('[Setup Directory Permission]');

        $storagePath = $this->getBasePath('storage');
        $bootCachePath = $this->getBasePath('bootstrap/cache');
        $storagePerm = $bootCachePerm = '0707';

        if (!$this->noInteraction) {
            $this->line('Input directory permission for storage.');

            $storagePerm = $this->ask('./storage directory permission', '0707');
            $bootCachePerm = $this->ask('./bootstrap/cache directory permission', '0707');
        } else {
            $this->line("passed");
        }

        $process = new Process("chmod -R $storagePerm $storagePath");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $process = new Process("chmod -R $bootCachePerm $bootCachePath");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    /**
     * markInstalled
     *
     * @return void
     */
    private function markInstalled()
    {
        $markFile = $path = $this->getBasePath('storage/app/installed');
        touch($markFile);
    }
}
