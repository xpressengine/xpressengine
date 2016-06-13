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
        return 'Textarea';
    }

    /**
     * Get config data for the editor
     *
     * @return array
     */
    public function getConfigData()
    {
        return [];
    }

    /**
     * Get activated tool's identifier for the editor
     *
     * @return array
     */
    public function getActivateToolIds()
    {
        return [];
    }

    /**
     * Compile the raw content to be useful
     *
     * @param string $content content
     * @return string
     */
    public function compile($content)
    {
        return $content;
    }
}
