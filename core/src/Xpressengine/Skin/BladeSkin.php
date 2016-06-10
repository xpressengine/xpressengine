<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skin;

use Xpressengine\Skin\Exceptions\PathNotAssignedException;

/**
 * 편의를 위해 AbstractSkin을 확장한 클래스. Blade 템플릿을 사용하는 스킨을 제작하고 싶을 경우, 이 클래스를 상속받아 사용하길 권장한다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class BladeSkin extends AbstractSkin
{
    /**
     * @var string 사용할 blade 파일들이 저장돼 있는 디렉토리의 경로, 실제경로가 아닌 view name형식의 경로이다.
     */
    protected $path = '';

    /**
     * view name을 찾아주는 메소드
     *
     * @param string $viewPath 경로를 제외한 파일의 view 이름
     *
     * @return string
     */
    public function getSkinPath($viewPath = '')
    {
        if (!$this->path) {
            $e = new PathNotAssignedException();
            $e->setMessage('스킨에서 사용할 blade 파일이 위치한 기본 디렉토리의 경로를 반드시 $path 필드에 지정해야 합니다.');
            throw $e;
        }
        return $this->path.($viewPath ? '.'.$viewPath : $viewPath);
    }

    /**
     * 만약 view 이름과 동일한 메소드명이 존재하면 그 메소드를 호출한다.
     * 동일한 이름의 메소드명이 존재하지 않으면, 동일한 이름의 blade 파일을 render한다.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $view = $this->view;
        $method = ucwords(str_replace(['-', '_', '.'], ' ', $view));
        $method = lcfirst(str_replace(' ', '', $method));

        // for php7
        if ($method === 'list') {
            $method = 'listView';
        }

        if (method_exists($this, $method)) {
            return $this->$method($view);
        } else {
            return $this->renderBlade($view);
        }
    }

    /**
     * view 이름과 동일한 blade 파일을 찾아서 render한다.
     *
     * @param string $view view 이름, null일 경우 $this->view를 대신 사용한다.
     *
     * @return \Illuminate\View\View
     */
    protected function renderBlade($view = null)
    {
        if ($view === null) {
            $view = $this->view;
        }

        return view(
            $this->getSkinPath($view),
            $this->data,
            [
                '_skin' => function ($path) {
                    return $this->getSkinPath($path);
                },
                '_config' => $this->config
            ]
        );
    }
}
