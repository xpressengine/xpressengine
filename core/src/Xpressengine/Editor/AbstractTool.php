<?php
/**
 * AbstractTool
 *
 * PHP version 5
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Editor;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * Class AbstractTool
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractTool implements ComponentInterface, \JsonSerializable
{
    use ComponentTrait;

    /**
     * Instance identifier
     *
     * @var string
     */
    protected $instanceId;

    /**
     * AbstractTool constructor.
     *
     * @param string $instanceId Instance identifier
     */
    public function __construct($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    /**
     * Initialize assets for the tool
     *
     * @return void
     */
    abstract public function initAssets();

    /**
     * Get the tool's symbol
     *
     * @return array ['normal' => '...', 'large' => '...']
     */
    abstract public function getIcon();

    /**
     * Get options for the tool
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Indicates if usable the tool
     *
     * @return bool
     */
    public function enable()
    {
        return true;
    }

    /**
     * Get uri string for tool setting by instance identifier
     *
     * @param string $instanceId instance identifier
     * @return string|null
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }

    /**
     * Compile the raw content to be useful
     *
     * @param string $content content
     * @return string
     */
    abstract public function compile($content);

    /**
     * Convert the object into something JSON serializable.
     *
     * @return mixed data which can be serialized by <b>json_encode</b>
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'icon' => $this->getIcon(),
            'options' => $this->getOptions(),
            'enable' => $this->enable(),
        ];
    }
}
