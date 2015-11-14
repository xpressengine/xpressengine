<?php
namespace App\Installation;

use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Filesystem\Filesystem;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use Validator;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Support\Migration;

/**
 * @package     App\Installation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class InstallCommand extends Command
{
    /**
     * @var string path for install
     */
    protected $installPath;

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
     * InstallCommand constructor.
     *
     * @param null|string $configFile
     * @param bool        $useConfigFileInfo
     */
    public function __construct($noInteraction = false, $configFile = null)
    {
        if ($configFile !== null && realpath($configFile) !== false) {
            $this->configFile = realpath($configFile);
            $config = Yaml::parse(file_get_contents($this->configFile));
            if ($config !== null) {
                $this->defaultInfos = array_merge($this->defaultInfos, $config);
            }

            // configFile 있을 경우에만 noInteraction 가능
            $this->noInteraction = $noInteraction;
        }
        parent::__construct();
    }

    /**
     * initialize
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->env = $this->getDefaultEnv();
    }

    /**
     * setInstallPath
     *
     * @param $path
     *
     * @return $this
     */
    public function setInstallPath($path)
    {
        $this->installPath = $path;
        return $this;
    }

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('install')->setDescription('Install Xpressengine application');
        $this->addArgument('path', InputArgument::OPTIONAL);
    }

    /**
     * process
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Exception
     */
    protected function process(InputInterface $input, OutputInterface $output)
    {
        // get config from config file
        //$config = $this->getConfigFromFile();

        // get db info
        $this->getDBInfo($input, $output);

        // validate db info
        $this->validateDBInfo($input, $output, $this->defaultInfos['database']);

        // set db info
        $this->setDBInfo($this->defaultInfos['database']);

        // get site info
        $this->getSiteInfo($input, $output);

        // set site info
        $this->setSiteInfo($this->defaultInfos['site']);


        // load framework, migrations, installPlugin, run composer post script
        $this->installFramework($input, $output);


        // create admin and login
        $this->getAdminInfo($input, $output);
        $this->createAdminAndLogin($this->defaultInfos['admin']);

        // make welcomepage
        $this->initializeCore();

        $this->disableDebugMode();

        // change directory permissions
        $this->setStorageDirectoryPermission($input, $output);

        $output->writeln("Install was completed successfully.".PHP_EOL);
    }

    /**
     * bootInstallFramework
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return mixed
     * @throws Exception
     */
    private function bootInstallFramework(InputInterface $input, OutputInterface $output)
    {
        require $this->installPath('vendor/autoload.php');

        $appFile = $this->installPath('bootstrap/app.php');
        if (!file_exists($appFile)) {
            throw new Exception('Unable to find app loader: ~/bootstrap/app.php');
        }

        $app = include($appFile);
        $kernel = $app->make(Kernel::class);
        $kernel->bootstrap();

        return $app;
    }

    /**
     * bootFramework
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return mixed
     * @throws Exception
     */
    private function bootFramework(InputInterface $input, OutputInterface $output)
    {
        require $this->installPath('vendor/autoload.php');

        $appFile = $this->installPath('bootstrap/app.php');
        if (!file_exists($appFile)) {
            throw new Exception('Unable to find app loader: ~/bootstrap/app.php');
        }

        $app = include($appFile);
        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
        $kernel->bootstrap();

        return $app;
    }

    /**
     * getDBInfo
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    private function getDBInfo(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>[Setup Database(MySQL)]</info>");

        if ($this->noInteraction) {
            $output->writeln("passed");
            return;
        }

        $output->writeln("Input Database Information.");

        $dbInfo = $this->defaultInfos['database'];

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        // host
        $question = new Question("<comment>Host [{$dbInfo['host']}]: </comment>", $dbInfo['host']);
        $dbInfo['host'] = $questionHelper->ask($input, $output, $question);

        // port
        $question = new Question("<comment>Port [{$dbInfo['port']}]: </comment>", $dbInfo['port']);
        $dbInfo['port'] = $questionHelper->ask($input, $output, $question);

        // dbname
        $question = new Question("<comment>Database name [{$dbInfo['dbname']}]: </comment>", $dbInfo['dbname']);
        $dbInfo['dbname'] = $questionHelper->ask($input, $output, $question);

        // username
        $question = new Question("<comment>UserID [{$dbInfo['username']}]: </comment>", $dbInfo['username']);
        $dbInfo['username'] = $questionHelper->ask($input, $output, $question);

        // password
        $default = '';
        if (isset($dbInfo['password']) && $dbInfo['password'] !== null) {
            $default = ' [imported from config file]';
        }
        $question = new Question("<comment>Password{$default}: </comment>", $dbInfo['password']);
        $question->setHidden(true)->setHiddenFallback(false);
        $dbInfo['password'] = $questionHelper->ask($input, $output, $question);

        $this->defaultInfos['database'] = $dbInfo;
    }

    /**
     * installFramework
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Exception
     */
    protected function installFramework(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("\n<info>[Base Framework load]</info>");
        $output->writeln("Base Framework is loading...");

        $this->writeEnvFile();

        // boot framework on install mode
        $app = $this->app = $this->bootInstallFramework($input, $output);

        // migration
        // 각 패키지마다 필요한 database table을 생성하고, seeding
        // 필요한 directory와 file을 생성한다.
        $this->migrateCore();

        // booting framework with xpressengine service providers
        $app = $this->app = $this->bootFramework($input, $output);

        // install and activate default plugins
        $this->installBasePlugins();

        // booting framework with xpressengine service providers
        $app = $this->app = $this->bootFramework($input, $output);

        // composer의 post script를 run한다.
        // script - optimizing & key generation
        $this->runPostScript($output);

        $output->writeln("Base Framework is loaded\n");
    }

    /**
     * getAdminInfo
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    private function getAdminInfo(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("\n<info>[Setup Admin infomation]</info>");

        if ($this->noInteraction) {
            $output->writeln("passed");
            return;
        }

        $output->writeln("Input information for site admin.");

        $adminInfo = $this->defaultInfos['admin'];

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        // email
        $question = new Question("<comment>Email [{$adminInfo['email']}]: </comment>", $adminInfo['email']);
        $question->setValidator(
            function ($email) {
                $validate = Validator::make(
                    ['email' => $email],
                    [
                        'email' => 'email'
                    ]
                );
                if ($validate->fails()) {
                    throw new \Exception('Invalid Email address.');
                }
                return $email;
            }
        );

        $question->setMaxAttempts(null);
        $adminInfo['email'] = $questionHelper->ask($input, $output, $question);

        // displayName
        $question = new Question("<comment>Name [{$adminInfo['displayName']}]:</comment> ", $adminInfo['displayName']);
        $question->setValidator(
            function ($displayName) {
                if (strlen(trim($displayName)) === 0) {
                    throw new \Exception('Input Name');
                }
                return $displayName;
            }
        );
        $question->setMaxAttempts(null);
        $adminInfo['displayName'] = $questionHelper->ask($input, $output, $question);

        // password
        $default = '';
        if (isset($adminInfo['password']) && $adminInfo['password'] !== null) {
            $default = ' [imported from config file]';
        }
        $question = new Question("<comment>Password{$default}: </comment> ", $adminInfo['password']);
        $question->setValidator(
            function ($password) {
                if (strlen($password) === 0) {
                    throw new \Exception('Input password.');
                }
                return $password;
            }
        );
        $question->setMaxAttempts(null);
        $question->setHidden(true)->setHiddenFallback(false);
        $adminInfo['password'] = $questionHelper->ask($input, $output, $question);

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

        // login admin
        /** @var Guard $auth */
        $auth = app('auth');
        $auth->login($admin);
    }

    /**
     * validateDBInfo
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param                 $dbInfo
     *
     * @return bool
     * @throws Exception
     */
    private function validateDBInfo(InputInterface $input, OutputInterface $output, $dbInfo)
    {
        $output->writeln("\n<info>[Checking Database Connection]</info>");
        $output->writeln("Connecting Database using inputted database information..");

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
        } catch (Exception $e) {
            $output->writeln("\n<error>Connection failed!!</error>");
            throw $e;
        }

        if ($count !== '0') {
            $message = "database {$dbInfo['dbname']} is not empty. Please drop all tables in {$dbInfo['dbname']}";
            $output->writeln("\n<error>$message</error>");
            throw new Exception($message);
        }

        $output->writeln("Connection successful.");
        return true;
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
     * installPath
     *
     * @param null $path
     *
     * @return string
     */
    private function installPath($path = null)
    {
        return $this->installPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * runPostScript
     *
     * @param OutputInterface $output
     *
     * @return void
     */
    private function runPostScript(OutputInterface $output)
    {
        $composer = $this->findComposer();
        $commands = [
            $composer.' run-script post-install-cmd',
            $composer.' run-script post-create-project-cmd',
        ];

        $process = new Process(implode(' && ', $commands), $this->installPath(), null, null, null);

        $process->run(
            function ($type, $line) use ($output) {
                $output->write($line);
            }
        );
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
MAIL_ENCRYPTION=null";
    }

    /**
     * setStorageDirectoryPermission
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    private function setStorageDirectoryPermission(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("\n<info>[Setup Directory Permission]</info>");

        $path = $this->installPath('storage');
        $permission = '0707';

        if (!$this->noInteraction) {
            $output->writeln("Input directory permission for storage.");
            /** @var QuestionHelper $questionHelper */
            $questionHelper = $this->getHelper('question');

            $question = new Question("<comment>./storage directory permission [0707]</comment>: ", '0707');
            $permission = $questionHelper->ask($input, $output, $question);
        } else {
            $output->writeln("passed");
        }

        $process = new Process("chmod -R $permission $path");
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    /**
     * getSiteInfo
     *
     * @param $input
     * @param $output
     *
     * @return void
     */
    private function getSiteInfo($input, $output)
    {
        $output->writeln("\n<info>[Setup Site]</info>");

        if ($this->noInteraction) {
            $output->writeln("passed");
            return;
        }

        $output->writeln("Input information for site.");

        $siteInfo = $this->defaultInfos['site'];

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        // site url
        $question = new Question("<comment>site url [{$siteInfo['url']}]: </comment>", $siteInfo['url']);
        $question->setValidator(
            function ($url) {
                if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                    throw new \Exception('Invalid URL Format.');
                }
                return $url;
            }
        );
        $question->setMaxAttempts(null);

        $siteInfo['url'] = $questionHelper->ask($input, $output, $question);

        // timezone
        $question = new Question("<comment>Timezone [{$siteInfo['timezone']}]: </comment>", $siteInfo['timezone']);
        $question->setValidator(
            function ($timezone) {
                if (in_array($timezone, timezone_identifiers_list()) === false) {
                    throw new \Exception('Inputted timezone do not exist.');
                }

                return $timezone;
            }
        );
        $question->setMaxAttempts(null);
        $siteInfo['timezone'] = $questionHelper->ask($input, $output, $question);

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
     * execute
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->executed === false) {
            $this->executed = true;
            return $this->process($input, $output);
        }
    }

    /**
     * interact
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if ($this->executed === false) {
            $this->executed = true;
            return $this->process($input, $output);
        }
    }

    /**
     * writeEnvFile
     *
     * @return void
     */
    private function writeEnvFile()
    {
        $path = $this->installPath('.env');
        file_put_contents($path, $this->env);
    }

    /**
     * disableDebugMode
     *
     * @return void
     */
    private function disableDebugMode()
    {
        // for sync APP_KEY
        $this->env = file_get_contents($this->installPath('.env'));

        $this->setEnv('APP_DEBUG', 'false', 'true');
        $this->writeEnvFile();
    }
}
