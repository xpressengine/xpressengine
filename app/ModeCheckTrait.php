<?php
/**
 * ModeCheckTrait.php
 *
 * PHP version 7
 *
 * @category    Bootstrap
 * @package     App
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace App;

use Illuminate\Support\Str;

/**
 * Trait ModeCheckTrait
 *
 * @category    Bootstrap
 * @package     App
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
trait ModeCheckTrait
{
    /**
     * Add event listener if the application is safe mode.
     *
     * @return void
     */
    protected function checkSafeMode()
    {
        app('events')->listen(
            'bootstrapped: App\Bootstrappers\LoadConfiguration',
            function ($app) {
                $config = $app['config'];
                $request = $app['request'];

                $safeModePrefix = $config['xe.routing.safeModePrefix'];

                if ($request->segment(1) == $safeModePrefix) {
                    $providers = $config['app.providers'];
                    $providers = array_filter($providers, function ($p) {
                        return Str::startsWith($p, 'Illuminate\\');
                    });

                    $providers[] = \App\Providers\SafeModeServiceProvider::class;

                    $config->set('app.providers', $providers);
                }
            }
        );
    }
}
