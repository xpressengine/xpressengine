<?php
/**
 * ReleaseProvider.php
 *
 * PHP version 7
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class ReleaseProvider
{
    protected $filesystem;

    protected $coreVersions;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getLatestCoreVersion()
    {
        $versions = $this->coreVersions();

        return end($versions);
    }

    public function coreVersions()
    {
        if (!$this->coreVersions) {
            $response = $this->getHttpClient()->request(
                'GET',
                'http://start.xpressengine.io/download/versions.txt'
            );

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('fail to get released information');
            }

            $lines = explode(PHP_EOL, $response->getBody()->getContents());
            $this->coreVersions = Collection::make($lines)->filter()->map(function ($v) {
                return basename(trim($v), '.zip');
            })->sort('version_compare')->values()->all();
        }

        return $this->coreVersions;
    }

    public function getUpdatableVersions()
    {
        return Collection::make($this->coreVersions())
            ->partition(function ($version) {
                return version_compare(__XE_VERSION__, $version) === -1;
            })->first()->values()->all();
    }

    public function download($ver, $dir)
    {
        if (!$this->filesystem->isDirectory($dir)) {
            $this->filesystem->makeDirectory($dir, 0755, true);
        }

        $file = $this->getFileName($ver);
        $filepath = $dir.'/'.$file;
        $response = $this->getHttpClient()->request(
            'GET',
            'http://start.xpressengine.io/download/'.$file,
            ['sink' => $filepath]
        );

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("fail to download zip file [$file]");
        }

        return $filepath;
    }

    protected function getFileName($ver)
    {
        return 'changed.'. $ver . '.zip';
    }

    protected function getHttpClient()
    {
        return new \GuzzleHttp\Client();
    }
}
