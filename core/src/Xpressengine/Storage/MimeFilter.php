<?php
/**
 * MimeFilter.php
 *
 * PHP version 7
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MimeFilter
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MimeFilter
{
    /**
     * filesystem config
     *
     * @var array
     */
    protected $config;

    /**
     * MimeFilter constructor.
     *
     * @param array $config config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Determine if the given file is valid.
     *
     * @param UploadedFile $uploaded uploaded file
     * @param string|null  $type     filter type
     * @return bool
     */
    public function isValid(UploadedFile $uploaded, $type = null)
    {
        $type = $type ?: $this->getDefaultFilter();

        if ($type === 'none') {
            return true;
        }

        $method = strtolower($type).'Filter';
        if (method_exists($this, $method)) {
            return $this->$method(strtolower($uploaded->getClientOriginalExtension()), $uploaded->getMimeType());
        }

        throw new InvalidArgumentException("Filter [$type] not supported.");
    }

    /**
     * Filtering by whitelist.
     *
     * @param string $extension extension of the file
     * @param string $mimeType  mime-type of the file
     * @return bool
     */
    protected function whiteFilter($extension, $mimeType)
    {
        $map = array_merge($this->getMap('white'), $this->getMap('black'));
        $mimes = $map[$extension] ?? [];

        return in_array($mimeType, (array)$mimes);
    }

    /**
     * Filtering by blacklist.
     *
     * @param string $extension extension of the file
     * @param string $mimeType  mime-type of the file
     * @return bool
     */
    protected function blackFilter($extension, $mimeType)
    {
        $map = $this->getMap('black');
        if (!$mimes = $map[$extension] ?? null) {
            return true;
        }

        return in_array($mimeType, (array)$mimes);
    }

    /**
     * Returns the mime-type map for filtering.
     *
     * @param string $type type keyword
     * @return array
     */
    protected function getMap($type)
    {
        return $this->config['mimes'][$type];
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultFilter()
    {
        return $this->config['filter'];
    }
}
