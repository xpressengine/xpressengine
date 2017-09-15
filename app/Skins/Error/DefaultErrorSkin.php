<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Skins\Error;

use \Xpressengine\Skin\AbstractSkin;
use View;

/**
 * Class DefaultErrorSkin
 * @package App\Skins\Error
 * @deprecated
 */
class DefaultErrorSkin extends AbstractSkin
{
    public static $id = 'error/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '에러 페이지 스킨',
        'description' => 'Xpressengine 의 에러 페이지 기본 스킨입니다'
    ];

    /**
     * render
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $exception = $this->data['exception'];
        $errorContentsFile = '500';
        if (
            method_exists($exception, 'getStatusCode') &&
            file_exists($this->getViewFilePath($exception->getStatusCode()))
        ) {
            $errorContentsFile = $exception->getStatusCode();
        }
        $errorContents = View::file($this->getViewFilePath($errorContentsFile), $this->data)->render();

        $view = View::file($this->getViewFilePath($this->view), $this->data, ['errorContents'=>$errorContents]);

        return $view;
    }

    /**
     * @param $view
     * @return string
     */
    public function getViewFilePath($view)
    {
        return base_path('resources/views/errors/'.$view.'.blade.php');
    }
}
