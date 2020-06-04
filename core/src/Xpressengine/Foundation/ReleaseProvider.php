<?php
/**
 * ReleaseProvider.php
 *
 * PHP version 7
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

/**
 * Class ReleaseProvider
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ReleaseProvider
{
    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Released core versions
     *
     * @var array
     */
    protected $coreVersions;

    /**
     * ReleaseProvider constructor.
     *
     * @param Filesystem $filesystem Filesystem instance
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Get latest version.
     *
     * @return string
     * @throws \Exception
     */
    public function getLatestCoreVersion()
    {
        $versions = $this->coreVersions();

        return end($versions);
    }

    /**
     * Get released core versions.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
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

            $lines = array_map("rtrim", explode("\n", $response->getBody()->getContents()));
            $this->coreVersions = Collection::make($lines)->filter()->map(function ($v) {
                return basename(trim($v), '.zip');
            })->sort('version_compare')->values()->all();
        }

        return $this->coreVersions;
    }

    /**
     * Get updatable versions.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUpdatableVersions()
    {
        return Collection::make($this->coreVersions())
            ->partition(function ($version) {
                return version_compare(__XE_VERSION__, $version) === -1;
            })->first()->values()->all();
    }

    /**
     * Download release
     *
     * @param string $ver version
     * @param string $dir directory for file save
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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

    /**
     * Get release file name.
     *
     * @param string $ver version
     * @return string
     */
    protected function getFileName($ver)
    {
        return 'changed.'. $ver . '.zip';
    }

    /**
     * Get http client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        return new \GuzzleHttp\Client();
    }
}
