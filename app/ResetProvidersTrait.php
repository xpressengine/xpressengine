<?php

/**
 * ResetProvidersTrait.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace App;

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
                    return substr($p, 0, strlen('Illuminate')) == 'Illuminate';
                });

                foreach ($customs as $custom) {
                    $providers[] = $custom;
                }

                $config->set('app.providers', $providers);
            }
        );
    }
}
