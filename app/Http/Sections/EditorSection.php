<?php
/**
 * EditorSection.php
 *
 * PHP version 7
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
