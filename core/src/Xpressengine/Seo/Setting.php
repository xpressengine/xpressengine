<?php
/**
 * This file is search engine optimizer setting.
 *
 * PHP version 5
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Seo;

use Illuminate\Support\Collection;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Models\Image;
use Xpressengine\Storage\Storage;

/**
 * Setting class
 *
 * @category    Seo
 * @package     Xpressengine\Seo
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Setting
{
    /**
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $cfg;

    /**
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * MediaManager instance
     *
     * @var MediaManager
     */
    protected $media;

    /**
     * Keygen instance
     *
     * @var Keygen
     */
    protected $keygen;

    /**
     * Key for config
     *
     * @var string
     */
    protected $key = 'seo';

    /**
     * ConfigEntity instance
     *
     * @var ConfigEntity
     */
    protected $config;

    /**
     * Image instance
     *
     * @var Image
     */
    protected $image;

    /**
     * Constructor
     *
     * @param ConfigManager $cfg     ConfigManager instance
     * @param Storage       $storage Storage instance
     * @param MediaManager  $media   MediaManager instance
     * @param Keygen        $keygen  Keygen instance
     */
    public function __construct(ConfigManager $cfg, Storage $storage, MediaManager $media, Keygen $keygen)
    {
        $this->cfg = $cfg;
        $this->storage = $storage;
        $this->media = $media;
        $this->keygen = $keygen;
    }

    /**
     * Check a setting information exists
     *
     * @return bool
     */
    public function exists()
    {
        if ($this->config !== null) {
            return true;
        }

        if (!$config = $this->cfg->get($this->key)) {
            return false;
        }

        $this->config = $config;

        return true;
    }

    /**
     * Get setting value
     *
     * @param string $name    key name
     * @param mixed  $default default value when not exists
     * @return mixed
     */
    public function get($name, $default = null)
    {
        $val = $this->exists() ? $this->config->get($name) : $default;

        return !empty($val) ? $val : $default;
    }

    /**
     * Set setting information
     *
     * @param array $data setting data
     * @return void
     */
    public function set(array $data)
    {
        $this->config = $this->cfg->set($this->key, $data);

        if (!$this->config->get('uuid')) {
            $this->config->set('uuid', $this->keygen->generate());

            $this->cfg->modify($this->config);
        }
    }

    /**
     * Get site representative image
     *
     * @return Image
     */
    public function getSiteImage()
    {
        if (!$this->image && $this->get('uuid')) {
            $files = $this->storage->fetchByFileable($this->get('uuid'));

            if (count($files) > 0) {
                $file = $files instanceof Collection ? $files->first() : current($files);
                $this->image = $this->media->make($file);
            }
        }

        return $this->image;
    }

    /**
     * Set site representative image
     *
     * @param Image $image image instance
     * @return void
     */
    public function setSiteImage(Image $image)
    {
        $this->storage->unBindAll($this->get('uuid'), true);
        $this->storage->bind($this->get('uuid'), $image);

        $this->image = $image;
    }
}
