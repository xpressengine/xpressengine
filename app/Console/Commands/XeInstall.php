<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Filesystem\Filesystem;
use PDO;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use Xpressengine\Support\Migration;
use Xpressengine\User\UserHandler;
use Illuminate\Support\Str;

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
     * @var bool
     */
    protected $executed = false;

    /**
     * @var array
     */
    protected $basePlugins = [
        'alice',
        'board',
        'claim',
        'ckeditor',
        'comment',
        'orientator',
        'page',
        'news_client',
        'widget_page',
    ];

    /**
     * @var
     */
    protected $migrations;

    protected $appKey;

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
            'locale' => 'ko',
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
            'prefix' => 'xe'
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
        // cache 가 활성화 되어있는 경우, 한번 읽은 파일은 한번의 요청처리 과정중
        // 해당 파일을 변경하더라도 새로 읽지 않고 cache 된 파일내용을 이용하게 됨
        // 설치 과정중 config 파일들이 생성된 후 오류 발생시 config 파일들이 남게 되고,
        // 이 상태에서 재시도시 이전 파일이 읽혀지게되어 내용을 변경하였더라도 반영이 되지 않음
        // cache disable 로 인해 성능이슈가 발생한다면 생성되었던 파일을 지우는 방식으로 변경
        ini_set('opcache.enable', 0);

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

        try {
            $this->process();

            $this->output->success('Install was completed successfully.');
        } catch (\Exception $e) {
            $this->output->error('Install fail!! Try again.');
            $note = [
                'Check point for reinstall:',
                ' * remove [.env] file',
                ' * remove all table in your database',
            ];
            $this->output->note(implode(PHP_EOL, $note));
            throw $e;
        }
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
     * @param string   $question
     * @param string   $default
     * @param callable $validator
     * @return string
     */
    public function askValidation($question, $default = null, callable $validator = null)
    {
        $question = new Question($question, $default);

        $question->setValidator($validator)->setMaxAttempts(null);

        return $this->output->askQuestion($question);
    }

    /**
     * process
     *
     * @return void
     */
    protected function process()
    {
        $this->info('[Check the system requirement]');
        $this->stepRequirement();

        // set db information
        $this->info('[Setup Database(MySQL)]');
        $this->stepDB();

        // set site information
        $this->info('[Setup Site]');
        $this->stepSiteInfo();

        // load framework, migrations, installPlugin, run composer post script
        $this->info('[Base Framework load]');
        $this->installFramework();

        // create admin and login
        $this->info('[Setup Admin information]');
        $this->stepAdmin();

        // make welcomepage
        $this->initializeCore();

        $this->disableDebugMode();

        // change directory permissions
        $this->info('[Setup Directory Permission]');
        $this->stepDirPermission();

        $this->stepAgreeCollectEnv();

        $this->markInstalled();
    }

    protected function stepRequirement()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        $versionCheck = constant('PHP_VERSION_ID') < 50509 ? false : true;

        if (!$versionCheck) {
            throw new \Exception('PHP version is not available');
        }

        $extensions = ['PDO', 'pdo_mysql', 'curl', 'gd', 'mbstring', 'openssl', 'zip'];
        $result = [];
        foreach ($extensions as $ext) {
            $result[$ext] = extension_loaded($ext);
            $this->output->write("- check {$ext} extension: ");
            if ($result[$ext]) {
                $this->info('true');
            } else {
                $this->error('false');
            }
        }

        $this->output->newLine();

        if (array_search(false, $result) > -1) {
            throw new \Exception('PHP extension is not ready! Please check php extensions. And retry install.');
        }
    }

    /**
     * stepDB
     *
     * @return void
     */
    protected function stepDB()
    {
        try {
            // get db info
            $this->getDBInfo();
            // validate db info
            $this->validateDBInfo($this->defaultInfos['database']);
            // set db info
            $this->setDBInfo($this->defaultInfos['database']);
        } catch (\Exception $e) {
            if ($this->noInteraction) {
                throw $e;
            }

            $this->defaultInfos['database']['password'] = null;
            $this->stepDB();
        }
    }

    /**
     * stepSiteInfo
     *
     * @return void
     */
    protected function stepSiteInfo()
    {
        // get site info
        $this->getSiteInfo();

        // set site info
        $this->setSiteInfo($this->defaultInfos['site']);
    }

    /**
     * stepAdmin
     *
     * @return void
     */
    protected function stepAdmin()
    {
        try {
            // create admin and login
            $this->getAdminInfo();
            $this->createAdminAndLogin($this->defaultInfos['admin']);
        } catch (\Exception $e) {
            if ($this->noInteraction) {
                throw $e;
            }

            $this->defaultInfos['admin']['password'] = null;
            $this->stepAdmin();
        }
    }

    /**
     * stepDirPermission
     *
     * @return void
     */
    protected function stepDirPermission()
    {
        try {
            $this->setStorageDirPermission();
        } catch (\Exception $e) {
            $this->error('Fail to change storage directory permission. Check directory after install.' . PHP_EOL . ' message: '. $e->getMessage());
        }

        try {
            $this->setBootCacheDirPermission();
        } catch (\Exception $e) {
            $this->error('Fail to change bootstrap cache directory permission. Check directory after install.' . PHP_EOL . ' message: '. $e->getMessage());
        }
    }

    protected function stepAgreeCollectEnv()
    {
        if ($this->noInteraction) {
            return;
        }

        $this->warn(
            PHP_EOL
            . 'Try to collect environmental information for debugging from server of XE installed.'
            . PHP_EOL
            . 'Your personal information will not be collected.'
        );
        $answer = $this->askValidation('Do you agree to collect your system environmental information?', 'yes', function ($value) {
            if (!in_array($value, ['yes', 'no'])) {
                throw new \Exception('Input only yes or no.');
            }

            return $value === 'yes';
        });

        if ($answer === true) {
            app('xe.plugin.news_client')->getHandler()->setAgree(true);
        }
    }

    /**
     * getDBInfo
     *
     * @return void
     */
    private function getDBInfo()
    {
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

     * @param  array $dbInfo
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
            $this->output->error('Connection failed!! Check Your Database!');
            throw $e;
        }

        $this->line('Connection successful.');
        $this->output->newLine();

        return true;
    }

    /**
     * setDBInfo
     *
     * @param array $dbInfo
     * @return void
     */
    private function setDBInfo($dbInfo)
    {
        $prefix = $this->ask("Table Prefix", $dbInfo['prefix']);

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
                    'prefix' => $prefix . '_',
                    'strict'    => false,
                ],
            ]
        ];

        $this->configFileGenerate('database', $info);
    }

    /**
     * configFileGenerate
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    private function configFileGenerate($key, array $data)
    {
        $dir = config_path() . '/production';
        $this->makeDir($dir);

        $data = $this->encodeArr2Str($data);

        $file = $dir . "/{$key}.php";
        file_put_contents($file, '<?php' . str_repeat(PHP_EOL, 2) . 'return [' . PHP_EOL . $data . '];' . PHP_EOL);
    }

    /**
     * makeDir
     *
     * @param string $dir
     * @return bool
     */
    private function makeDir($dir)
    {
        /** @var Filesystem $filesystem */
        $filesystem = app('files');
        if (!$filesystem->isDirectory($dir)) {
            return $filesystem->makeDirectory($dir);
        }

        return true;
    }

    /**
     * encodeArr2Str
     *
     * @param array $arr
     * @param int $depth
     * @return string
     */
    private function encodeArr2Str(array $arr, $depth = 0)
    {
        $output = '';

        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $output .= $this->getIndent($depth) . "'{$key}' => " . '[' . PHP_EOL . $this->encodeArr2Str($val, $depth + 1) . $this->getIndent($depth) . '],' . PHP_EOL;
            } else {
                if (is_bool($val)) {
                    $val = $val ? 'true' : 'false';
                } elseif (!is_int($val)) {
                    $val = "'{$val}'";
                }
                $output .= $this->getIndent($depth) . "'{$key}' => " . $val .',' . PHP_EOL;
            }
        }

        return $output;
    }

    /**
     * getIndent
     *
     * @param int $depth
     * @return string
     */
    private function getIndent($depth)
    {
        $indent = '';
        for ($a = 0; $a <= $depth; $a++) {
            $indent .= str_repeat(' ', 4);
        }

        return $indent;
    }

    /**
     * getSiteInfo
     *
     * @return void
     */
    private function getSiteInfo()
    {
        if ($this->noInteraction) {
            $this->line('passed');
            return;
        }

        $this->line('Input information for site.');

        $siteInfo = $this->defaultInfos['site'];

        // site url
        $siteInfo['url'] = $this->askValidation('site url', $siteInfo['url'], function ($url) {
            $url = trim($url, "/");
            if (!preg_match('/^(http(s)?\:\/\/)/', $url)) {
                $url = 'http://' . $url;
            }
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

        // locale
        $siteInfo['locale'] = $this->askValidation('Locale (ko or en)', $siteInfo['locale'], function ($locale) {
            if ($locale !== 'ko') {
                $locale = 'en';
            }
            return $locale;
        });

        $this->defaultInfos['site'] = $siteInfo;
    }

    /**
     * setSiteInfo
     *
     * @param $siteInfo
     * @param $debug
     *
     * @return void
     */
    private function setSiteInfo($siteInfo, $debug = true)
    {
        $info = [
            'debug' => $debug,
            'url' => $siteInfo['url'],
            'timezone' => $siteInfo['timezone'],
            'key' => $this->getKey(),
        ];

        $this->configFileGenerate('app', $info);

        $locales = ['ko', 'en'];
        if ($siteInfo['locale'] != 'ko') {
            $locales = ['en', 'ko'];
        }
        $info = [
            'lang' => [
                'locales' => $locales,
            ],
        ];
        $this->configFileGenerate('xe', $info);
    }

    private function getKey()
    {
        if (!$this->appKey) {
            $this->appKey = $this->getRandomKey($this->laravel['config']['app.cipher']);
        }

        return $this->appKey;
    }

    /**
     * Generate a random key for the application.
     *
     * Illuminate\Foundation\Console\KeyGenerateCommand
     *
     * @param  string  $cipher
     * @return string
     */
    private function getRandomKey($cipher)
    {
        if ($cipher === 'AES-128-CBC') {
            return Str::random(16);
        }

        return Str::random(32);
    }

    /**
     * installFramework
     *
     * @return void
     */
    protected function installFramework()
    {
        $this->line('Base Framework is loading...');

        // reboot for load config
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

        $this->line("Base Framework is loaded\n");
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
     * getAdminInfo
     *
     * @return void
     */
    private function getAdminInfo()
    {
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

        $adminInfo['password'] = $this->getAdminPassword($adminInfo);

        $this->defaultInfos['admin'] = $adminInfo;
    }

    /**
     * getAdminPassword
     *
     * @param array $adminInfo
     * @return string
     */
    private function getAdminPassword($adminInfo)
    {
        // password
        $default = null;
        if (isset($adminInfo['password']) && $adminInfo['password'] !== null) {
            $default = 'imported from config file';
        }
        $password = $this->secretDefault("Password", false, $default);
        if (!$password || $password == $default) {
            $password = $adminInfo['password'];
        } else {
            $repassword = $this->secretDefault("Password again", false);
            if ($password !== $repassword) {
                $this->output->error('Password not matched');
                $password = $this->getAdminPassword($adminInfo);
            }
        }

        return $password;
    }

    /**
     * createAdminAndLogin
     *
     * @param array $config
     * @return void
     * @throws \Exception
     */
    protected function createAdminAndLogin($config)
    {
        $config['rating'] = 'super';
        $config['status'] = 'activated';
        $config['emailConfirmed'] = true;

        // create admin account
        /** @var UserHandler $userHandler */
        $userHandler = app('xe.user');

        try {
            $admin = $userHandler->create($config);
        } catch (\Exception $e) {
            $this->output->error($e->getMessage());
            throw $e;
        }

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
        $this->setSiteInfo($this->defaultInfos['site'], false);
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

        foreach ($this->migrations as $migration) {
            if (method_exists($migration, 'initialized')) {
                $migration->initialized();
            }
        }
    }

    /**
     * setStorageDirPermission
     *
     * @return void
     */
    private function setStorageDirPermission()
    {
        $storagePath = $this->getBasePath('storage');
        $storagePerm = '0707';

        if (!$this->noInteraction) {
            $this->line('Input directory permission for storage.');

            $storagePerm = $this->ask('./storage directory permission', $storagePerm);
        } else {
            $this->line("passed");
        }

        $process = new Process("chmod -R $storagePerm $storagePath");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    /**
     * setBootCacheDirPermission
     *
     * @return void
     */
    private function setBootCacheDirPermission()
    {
        $bootCachePath = $this->getBasePath('bootstrap/cache');
        $bootCachePerm = '0707';

        if (!$this->noInteraction) {
            $this->line('Input directory permission for bootstrap cache.');

            $bootCachePerm = $this->ask('./bootstrap/cache directory permission', $bootCachePerm);
        } else {
            $this->line("passed");
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
        file_put_contents($markFile, __XE_VERSION__);
    }
}
