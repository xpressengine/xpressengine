<?php
namespace App\Bootstrappers;

use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as BaseLoadConfiguration;

class LoadConfiguration extends BaseLoadConfiguration
{
    /**
     * Load the configuration items from all of the files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @param  \Illuminate\Contracts\Config\Repository      $repository
     *
     * @return void
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        // app 에서 env 값이 설정되기 전이므로 시스템 값을 사용함
        $env = env('APP_ENV', 'production');

        $files = $this->getConfigurationFiles($app);
        $filesByEnv = [];

        foreach ($files as $key => $path) {
            // cascading config 지원을 위하여 별도로 저장.
            if (strpos($key, $env.'.') === 0) {
                $filesByEnv[$key] = $path;
                continue;
            }

            // cascading config 지원을 위하여 laravel 5.0 이상에서 제공하는 nesting config는 지원하지 않음.
            if (strpos($key, '.') !== false) {
                continue;
            }

            $repository->set($key, require $path);
        }

        // cascading config 적용
        $this->mergeEnv($repository, $env, $filesByEnv);
    }

    /**
     * Merge the items in the given files into the items.
     *
     * @param RepositoryContract $repository
     * @param string             $env
     * @param array              $filesByEnv
     *
     * @return void
     */
    protected function mergeEnv(RepositoryContract $repository, $env, $filesByEnv)
    {
        $ignoreCount = strlen($env) + 1;
        foreach ($filesByEnv as $key => $path) {
            $key = substr($key, $ignoreCount);
            $origin = $repository->get($key);

            $repository->set($key, array_replace_recursive($origin, require $path));
        }
    }

}
