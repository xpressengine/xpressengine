<?php
namespace App\Http\Controllers;

use Xpressengine\Http\Request;
use View;
use Artisan;
use File;
use Symfony\Component\Yaml\Yaml;

class InstallController extends Controller
{
    protected $phpVersion = 50509;

    public function index()
    {
        return View::make('install.index', []);
    }

    public function checkDirectoryPermission()
    {
        $request = app('request');

        // 파일을 쓰고 지우는 동작을 통해 permission 유무 체크
        $result = true;

        // 이것 저것 체크해야 하지만.. 지원 안하는것으로 결정되어 추가 개발 안함
        $configPath = storage_path('app');

        if ($request->format() == 'json') {
            return json_encode(['result' => $result]);
        } else {
            return $result;
        }
    }

    public function checkPHP()
    {
        $request = app('request');

        $result = PHP_VERSION_ID < $this->phpVersion ? false : true;
        $result = true;
        if ($request->format() == 'json') {
            return json_encode(['result' => $result]);
        } else {
            return $result;
        }
    }

    public function step1()
    {
        $request = app('request');

        return View::make('install.step1', []);
    }

    protected function checkSystem()
    {
        // throw exception

        if ($this->checkPermission() === false) {

        }
        if ($this->checkPHP() === false) {

        }
    }

    public function install()
    {
        $request = app('request');

        $this->validate($request, [
            'admin_email' => 'required|email',
            'admin_password' => 'required|confirmed',
            'admin_password_confirmation' => 'required',
            'database_name' => 'required',
            'database_password' => 'required',
        ]);

        // check database connect - throw exception
        // check database is empty - throw exception

        $this->checkSystem();


        $appKeyPath = storage_path('app') . '/appKey';
        $configPath = storage_path('app') . '/installConfig';

        $string = Yaml::dump([
            'site' => [
                'url' => $request->get('web_url') != '' ? $request->get('web_url') : 'http://localhost',
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

        $exitCode = Artisan::call('xe:install', [
            '--config' => $configPath,
            '--no-interaction' => true,
        ]);

        File::delete($configPath);
        File::delete($appKeyPath);

        return redirect('/');

    }
}
