<?php
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

    public function create()
    {
        if ($this->isInstalled() === true) {
            throw new \Exception('Already installed');
        }

        return View::make('install.create', []);
    }

    public function install(Request $request)
    {
        if ($this->isInstalled() === true) {
            throw new \Exception('Already installed');
        }

        app('config')->set('app.debug', true);
        
        $this->validate($request, [
            'admin_email' => 'required|email',
            'admin_password' => 'required|confirmed',
            'admin_password_confirmation' => 'required',
            'database_name' => 'required',
            'database_password' => 'required',
        ]);

        // check database connect - throw exception

        $appKeyPath = storage_path('app') . '/appKey';
        $configPath = storage_path('app') . '/installConfig';

        $string = Yaml::dump([
            'site' => [
                'url' => $request->get('web_url') != '' ? rtrim($request->get('web_url'), '/') : 'http://localhost',
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
}
