<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Artisan;
use File;
use Symfony\Component\Yaml\Yaml;

class InstallController extends Controller
{
    protected $phpVersion = 50509;

    /**
     * Is installed
     *
     * @return bool
     */
    protected function isInstalled()
    {
        return file_exists(storage_path() . '/app/installed');
    }

    public function install(Request $request)
    {
        if ($this->isInstalled() === true) {
            throw new \Exception('Already installed');
        }

        app('config')->set('app.debug', true);

        $url = $this->getUrl($request->get('web_url', ''));
        $validator = $this->getValidationFactory()->make(
            array_merge($request->all(), ['web_url' => $url]),
            [
                'admin_email' => 'required|email',
                'admin_password' => 'required|confirmed',
                'admin_password_confirmation' => 'required',
                'database_name' => 'required',
                'database_password' => 'required',
                'web_url' => 'url',
            ]
        );

        if ($validator->fails()) {
            return $this->back($validator->getMessageBag()->first());
        }

        // check database connect - throw exception

        $appKeyPath = storage_path('app') . '/appKey';
        $configPath = storage_path('app') . '/installConfig';

        $string = Yaml::dump([
            'site' => [
                'url' => $url != '' ? $url : 'http://localhost',
                'timezone' =>  $request->get('web_timezone') != '' ? $request->get('web_timezone') : 'Asia/Seoul',
            ],
            'admin' => [
                'email' => $request->get('admin_email'),
                'password' => $request->get('admin_password'),
                'displayName' => $request->get('admin_display_name') != '' ? $request->get('admin_display_name') : 'admin',
            ],
            'database' => [
                'host' => $request->get('database_host') != '' ? $request->get('database_host') : 'localhost',
                'port' => $request->get('database_port') != '' ? $request->get('database_port') : '3306',
                'dbname' => $request->get('database_name'),
                'username' => $request->get('database_user_name') != '' ? $request->get('database_user_name') : 'root',
                'password' => $request->get('database_password'),
            ],
        ]);

        File::put($configPath, $string);

        Artisan::call('xe:install', [
            '--config' => $configPath,
            '--no-interaction' => true,
        ]);

        File::delete($configPath);
        File::delete($appKeyPath);

        return redirect($request->root());
    }

    private function back($msg = null)
    {
        $alert = $msg ? 'alert("'.$msg.'");' : '';
        return sprintf('<script>%s history.back();</script>', $alert);
    }

    private function getUrl($url)
    {
        $url = trim($url, '/');
        if (!empty($url) && !preg_match('/^(http(s)?\:\/\/)/', $url)) {
            $url = 'http://' . $url;
        }

        return $url;
    }
}
