<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use Config;
use View;
use Xpressengine\Widget\AbstractWidget;

/**
 * SystemInfo.php
 *
 * PHP version 5
 *
 * @category
 */
class HtmlWidget extends AbstractWidget
{

    protected static $id = 'widget/xpressengine@html';

    /**
     * 위젯의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return 'HTML 직접 입력';
    }

    /**
     * render
     *
     * @return mixed
     * @internal param array $args to render parameter array
     *
     */
    public function render()
    {
        $content = htmlspecialchars_decode(array_get($this->config, 'content'));
        return $this->renderSkin(compact('content'));
    }

    /**
     * 위젯 설정 페이지에 출력할 폼을 출력한다.
     *
     * @param array $args 설정값
     *
     * @return string
     */
    public function renderSetting(array $args = [])
    {
        return uio('formTextarea', ['id'=>'', 'name'=>'content', 'label'=>'HTML', 'value'=>array_get($args, 'content')]);
    }

    /**
     * 사용자가 위젯 설정 페이지에 입력한 설정값을 저장하기 전에 전처리 한다.
     *
     * @param array $inputs 사용자가 입력한 설정값
     *
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
