<?php
/**
 * ResetProvidersTrait.php
 *
 * PHP version 7
 *
 * @category    Bootstrap
 * @package     App
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App;

use Illuminate\Support\Str;

/**
 * Class ResetProvidersTrait
 *
 * @category    Bootstrap
 * @package     App
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait ResetProvidersTrait
{
    /**
     * Define for providers of framework.
     *
     * @param array $customs
     * @return void
     */
    protected function resetProviders(array $customs = [])
    {
        app('events')->listen(
            'bootstrapped: App\Bootstrappers\LoadConfiguration',
            function ($app) use ($customs) {
                $config = $app['config'];

                $providers = $config['app.providers'];
                $providers = array_filter($providers, function ($p) {
                    return Str::startsWith($p, 'Illuminate\\');
                });

                foreach ($customs as $custom) {
                    $providers[] = $custom;
                }

                $config->set('app.providers', $providers);
            }
        );
    }
}
