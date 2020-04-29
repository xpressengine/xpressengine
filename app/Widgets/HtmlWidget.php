<?php
/**
 * HtmlWidget.php
 *
 * PHP version 7
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use Config;
use View;
use Xpressengine\Widget\AbstractWidget;

/**
 * Class HtmlWidget
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class HtmlWidget extends AbstractWidget
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@html';

    /**
     * Returns the title of the widget.
     *
     * @return string
     */
    public static function getTitle()
    {
        return 'HTML 직접 입력';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $content = htmlspecialchars_decode(array_get($this->config, 'content'));
        return $this->renderSkin(compact('content'));
    }

    /**
     * Show the setting form for the widget.
     *
     * @param array $args arguments
     * @return string|\Xpressengine\UIObject\AbstractUIObject
     * @throws \Exception
     */
    public function renderSetting(array $args = [])
    {
        return uio('formTextarea', ['id'=>'', 'name'=>'content', 'label'=>'HTML', 'value'=>array_get($args, 'content')]);
    }

    /**
     * Handle given input before saved.
     *
     * @param array $inputs inputs
     * @return array
     */
    public function resolveSetting(array $inputs = [])
    {
        $content = array_get($inputs, 'content');
        //$content = '<![CDATA['.$content.']]>';
        $content = htmlspecialchars($content);
        array_set($inputs, 'content', $content);
        return $inputs;
    }
}
