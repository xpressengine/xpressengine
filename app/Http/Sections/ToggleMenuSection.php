<?php
/**
 * ToggleMenuSection.php
 *
 * PHP version 7
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use XeToggleMenu;

/**
 * Class ToggleMenuSection
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ToggleMenuSection extends Section
{
    /**
     * The type.
     *
     * @var string
     */
    protected $type;

    /**
     * The instance id
     *
     * @var string|null
     */
    protected $instanceId;

    /**
     * ToggleMenuSection constructor.
     *
     * @param string      $type       type
     * @param string|null $instanceId instance id
     */
    public function __construct($type, $instanceId = null)
    {
        $this->type = $type;
        $this->instanceId = $instanceId;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $activated = XeToggleMenu::getActivated($this->type, $this->instanceId);
        $deactivated = XeToggleMenu::getDeactivated($this->type, $this->instanceId);
        $items = [];

        foreach ($activated as $key => $item) {
            $items[$key] = ['item' => $item, 'activated' => true];
        }
        foreach ($deactivated as $key => $item) {
            $items[$key] = ['item' => $item, 'activated' => false];
        }

        $typeIdable = str_replace(['/', '@'], '_', $this->type);

        return view('toggleMenu.setting', [
            'inherit' => XeToggleMenu::isInherit($this->type, $this->instanceId),
            'items' => $items,
            'type' => $this->type,
            'instanceId' => $this->instanceId,
            'typeIdable' => $typeIdable
        ]);
    }
}
