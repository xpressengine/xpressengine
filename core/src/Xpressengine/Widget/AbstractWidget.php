<?php
/**
 * AbstractWidget class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <develops@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * 이 클래스는 Xpressengine 에서 Widget 구현할 때 필요한 추상클래스이다.
 * Widget 를 Xpressengine 에 등록하려면
 * 이 추상 클래스를 상속받은 클래스를 작성하여야 한다.
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 */
abstract class AbstractWidget implements ComponentInterface
{
    use ComponentTrait;

    /**
     * @var array
     */
    public static $ratingWhiteList = ['super', 'manager', 'member', 'guest'];

    /**
     * 생성자. 모든 Widget 동일한 방식으로 생성되어야 한다.
     *
     */
    final public function __construct()
    {
        $this->init();
    }

    /**
     * init
     *
     * @return mixed
     */
    abstract protected function init();

    /**
     * Return this widget is widget code creation able or unable
     * codeCreationAble
     * default value is false
     *
     * @return boolean
     */
    public static function codeCreationAble()
    {
        return false;
    }

    /**
     * getCodeCreationForm
     *
     * @return mixed
     */
    abstract public function getCodeCreationForm();

    /**
     * render
     *
     * @param array $args to render parameter array
     *
     * @return mixed
     */
    abstract public function render(array $args);
}
