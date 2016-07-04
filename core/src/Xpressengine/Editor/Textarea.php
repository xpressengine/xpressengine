<?php
/**
 * Textarea
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

/**
 * Class Textarea
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Textarea extends AbstractEditor
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'editor/xpressengine@textarea';

    /**
     * The component information
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => 'Textarea'
    ];

    /**
     * Get a editor name
     *
     * @return string
     */
    public function getName()
    {
        return 'XEtextarea';
    }

    /**
     * Determine if a editor html usable.
     *
     * @return boolean
     */
    public function htmlable()
    {
        return false;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->frontend->js('assets/core/common/js/xe.textarea.define.js')
            ->before('assets/core/common/js/xe.editor.core.js')->load();

        return parent::render();
    }

    /**
     * Compile content body
     *
     * @param string $content content
     * @return string
     */
    protected function compileBody($content)
    {
        return $content;
    }
}
