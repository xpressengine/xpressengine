<?php
/**
 * XeInstall.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
use Xpressengine\Cubrid\CubridConnection;

/**
 * Class XeInstall
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
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
     * The plugins for activate after install.
     *
     * @var array
     */
    protected $basePlugins = [
        'board',
        'together',
        'claim',
        'ckeditor',
        'comment',
        'page',
        'news_client',
        'widget_page',
        'banner'
    ];

    /**
     * The list of class for migration.
     *
     * @var array
     */
    protected $migrations = [];

    /**
     * The key for the application.
     *
     * @var string
     */
    protected $appKey;

    /**
     * Default information.
     *
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
            'login_id' => 'admin',
            'password' => null,
            'display_name' => 'admin',
        ],
        'database' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => null,
            'port' => '3306',
            'username' => 'root',
            'password' => null,
            'prefix' => 'xe'
        ],
    ];

    /**
     * Indicates if interaction is disabled.
     *
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
     * @return void
     * @throws \Exception
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
            $config = Yaml::parse(file_get_contents(realpath($configFile)));
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
     * @param string $question question
     * @param bool   $fallback fallback
     * @param string $default  default answer
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
     * @param string   $question  question
     * @param string   $default   default answer
     * @param callable $validator validator
     * @return string
     */
    public function askValidation($question, $default = null, callable $validator = null)
    {
        $question = new Question($question, $default);

        $question->setValidator($validator)->setMaxAttempts(null);

        return $this->output->askQuestion($question);
    }

    /**
     * Do process.
     *
     * @return void
     * @throws \Exception
     */
    protected function process()
    {
        $this->info('[Check the system requirement]');
        $this->stepRequirement();

        // set db information
        $this->info('[Setup Database]');
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
        if(!windows_os()) {
            $this->info('[Setup Directory Permission]');
            $this->stepDirPermission();
        }

        $this->stepAgreeCollectEnv();

        $this->markInstalled();
    }

    /**
     * Check requirement.
     *
     * @return void
     * @throws \Exception
     */
    protected function stepRequirement()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        $versionCheck = constant('PHP_VERSION_ID') < 70000 ? false : true;

        if (!$versionCheck) {
            throw new \Exception('PHP version is not available');
        }

        $extensions = ['PDO', 'pdo_mysql', 'curl', 'fileinfo', 'gd', 'mbstring', 'openssl', 'zip'];
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
     * Set database connect information.
     *
     * @return void
     * @throws \Exception
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
     * Set site information.
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
     * Set administrator information.
     *
     * @return void
     * @throws \Exception
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
     * Set permission to directory.
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

    /**
     * Confirm collecting to environment and set.
     *
     * @return void
     */
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
     * Get database connect information.
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

        // driver
        $dbInfo['driver'] = $this->ask("Driver", $dbInfo['driver']);

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
     * Validate database connect information.
     *
     * @param  array $dbInfo connect information
     * @return bool
     * @throws \Exception
     */
    private function validateDBInfo($dbInfo)
    {
        $this->info('[Checking Database Connection]');
        $this->line('Connecting Database using inputted database information..');

        try {
            if($dbInfo['driver'] === 'cubrid'){
                $dsn = 'cubrid:host='.$dbInfo['host'].';dbname='.$dbInfo['dbname'];
            }else{
                $dsn = 'mysql:host='.$dbInfo['host'].';dbname='.$dbInfo['dbname'];
            }
            if ($dbInfo['port']) {
                $dsn .= ";port=".$dbInfo['port'];
            }

            $db = new PDO(
                $dsn, $dbInfo['username'], $dbInfo['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

        } catch (\Exception $e) {
            $this->output->error('Connection failed!! Check Your Database!' . $e->getMessage());
            throw $e;
        }

        $this->line('Connection successful.');
        $this->output->newLine();

        return true;
    }

    /**
     * Set database connect information.
     *
     * @param array $dbInfo connect information
     * @return void
     */
    private function setDBInfo($dbInfo)
    {
        $prefix = $this->ask("Table Prefix", $dbInfo['prefix']);

        $info = [
            'default' => $dbInfo['driver'],
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
                'cubrid' => [
                    'driver'   => 'cubrid',
                    'host'      => $dbInfo['host'],
                    'database'  => $dbInfo['dbname'],
                    'username'  => $dbInfo['username'],
                    'password'  => $dbInfo['password'],
                    'port'      => $dbInfo['port'],
                    'charset'  => 'utf8',
                    'prefix' => $prefix . '_',
                ]
            ]
        ];

        $this->configFileGenerate('database', $info);
    }

    /**
     * Generate a config file.
     *
     * @param string $key  key name
     * @param array  $data data
     * @return void
     */
    private function configFileGenerate($key, array $data)
    {
        $dir = config_path() . '/' . env('APP_ENV', 'production');
        $this->makeDir($dir);

        $data = $this->encodeArr2Str($data);

        $file = $dir . "/{$key}.php";
        file_put_contents($file, '<?php' . str_repeat(PHP_EOL, 2) . 'return [' . PHP_EOL . $data . '];' . PHP_EOL);
    }

    /**
     * Make directory.
     *
     * @param string $dir directory path
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
     * Encode array to string.
     *
     * @param array $arr   array
     * @param int   $depth depth
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
     * Get indent.
     *
     * @param int $depth depth
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
     * Get site information.
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
     * Set site information.
     *
     * @param array $siteInfo information
     * @param bool  $debug    set debug mode
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

    /**
     * Get application key for encryption.
     *
     * @return string
     */
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
     * @param string $cipher cipher
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
     * Install framework
     *
     * @return void
     * @throws \Exception
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
     * Get the path to the base of the install.
     *
     * @param string|null $path the path under the base path
     * @return string
     */
    private function getBasePath($path = null)
    {
        return base_path($path);
    }

    /**
     * Boot framework.
     *
     * @param bool $withXE enable XE
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

        // $app->resolving('db', function($db) {
        //     $db->extend('cubrid', function ($config, $name) {
        //         $config['name'] = $name;
        //         return new CubridConnection($config);
        //     });
        //
        // });

        if ($withXE) {
            $kernel->bootstrap(true);
        } else {
            $kernel->bootstrap();
        }

        return $app;
    }

    /**
     * Execute migrations for XE core.
     *
     * @return void
     */
    private function migrateCore()
    {
        /** @var Filesystem $filesystem */
        $filesystem = app('files');
        $files = $filesystem->files(base_path('migrations'));

        usort($files, function ($pre, $post) {
            return $pre->getFileName() > $post->getFileName();
        });

        $config = app('config');
        $config['database.default'] = $this->defaultInfos['database']['driver'];

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
     * Install base plugins.
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
     * Get administrator information.
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

        $adminInfo['login_id'] = $this->askValidation('ID', $adminInfo['login_id'], function ($loginId) {
            return $loginId;
        });

        // displayName
        $adminInfo['display_name'] = $this->askValidation('Nickname', $adminInfo['display_name'], function ($displayName) {
            if (strlen(trim($displayName)) === 0) {
                throw new \Exception('Input Nickname');
            }

            return $displayName;
        });

        $adminInfo['password'] = $this->getAdminPassword($adminInfo);

        $this->defaultInfos['admin'] = $adminInfo;
    }

    /**
     * Get administrator password for authentication.
     *
     * @param array $adminInfo administrator information
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
     * Create administrator account and login.
     *
     * @param array $config config for account
     * @return void
     * @throws \Exception
     */
    protected function createAdminAndLogin($config)
    {
        $config['rating'] = 'super';
        $config['status'] = 'activated';
        $config['emailConfirmed'] = true;

        if (isset($config['login_id']) === false) {
            $config['login_id'] = 'admin';
        }

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
                'name' => $config['display_name']
            ],
        ];
        $this->configFileGenerate('mail', $info);

        // create auth-admin config
        $info = [
            'admin' => [
                'session' => 'auth.admin',
                'expire' => 30,
                'password' => $config['password']
            ],
        ];
        $this->configFileGenerate('auth', $info);

        // login admin
        /** @var Guard $auth */
        $auth = app('auth');
        $auth->login($admin);
    }

    /**
     * Disable debug mode.
     *
     * @return void
     */
    private function disableDebugMode()
    {
        $this->setSiteInfo($this->defaultInfos['site'], false);
    }

    /**
     * Initialize XE core.
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
     * Set storage directory permission.
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
     * Set bootstrap cache directory permission.
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
     * Mark installed.
     *
     * @return void
     */
    private function markInstalled()
    {
        $markFile = $path = app()->getInstalledPath();
        file_put_contents($markFile, __XE_VERSION__);
    }
}
