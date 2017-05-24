<?php
/**
 * Site.php
 *
 * PHP version 5
 *
 * @category    Command
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Site\SiteHandler;

/**
 * Class Site
 *
 * @category    Command
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Site extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'site:host-update';
    /**
     * @var SiteHandler
     */
    protected $handler;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update site host information';

    /**
     * @param SiteHandler $handler site handler
     */
    public function __construct(SiteHandler $handler)
    {
        $this->handler = $handler;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $siteKey = $this->option('siteKey');
        $host = $this->option('host');

        $handler = $this->handler;

        try {
            $host = $this->validateHost($host);

            if ($site = $handler->find($siteKey)) {
                $handler->update($site, ['host' => $host]);
                $this->comment($this->description);
            } else {
                $this->error("Cannot find site information. (find key :{$siteKey})");
            }
        } catch (InvalidArgumentException $e) {
            $this->error("{$host} is incorrect host format. ex) example.com ");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['siteKey', null, InputOption::VALUE_REQUIRED, 'Site key', 'default'],
            ['host', null, InputOption::VALUE_REQUIRED, 'Host information to be changed'],
        ];
    }

    /**
     * validateHost
     *
     * @param string $host host
     *
     * @return string
     */
    private function validateHost($host)
    {
        if (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $host) //valid chars check
            && preg_match("/^.{1,253}$/", $host) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $host) //length of each label
        ) {
            return $host;
        } else {
            throw new InvalidArgumentException;
        }
    }
}
