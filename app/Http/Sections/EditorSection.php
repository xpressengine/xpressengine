<?php
/**
 * EditorSection.php
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

use View;
use XeEditor;

/**
 * Class EditorSection
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class EditorSection extends Section
{
    /**
     * The instance id
     *
     * @var string
     */
    protected $instanceId;

    /**
     * EditorSection constructor.
     *
     * @param string $instanceId instance id
     */
    public function __construct($instanceId)
    {
        $this->instanceId = $instanceId;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $editors = XeEditor::getAll();
        $selected = XeEditor::get($this->instanceId);

        return view('editor.section', [
            'instanceId' => $this->instanceId,
            'editors' => $editors,
            'selected' => $selected,
        ]);
    }
}
