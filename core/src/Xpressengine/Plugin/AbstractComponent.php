<?php
/**
 * Abstarct Module class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

/**
 * 플러그인에서 등록할 수 있는 XpressEngine의 구성요소(Component)의 추상클래스
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 */
abstract class AbstractComponent implements ComponentInterface
{
    use ComponentTrait;
}
