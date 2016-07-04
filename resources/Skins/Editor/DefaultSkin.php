<?php
/**
 * DefaultSkin
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Skins\Editor;

use Xpressengine\Skin\BladeSkin;

/**
 * Class DefaultSkin
 *
 * @category
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DefaultSkin extends BladeSkin
{
    /**
     * Component identifier
     *
     * @var string
     */
    protected static $id = 'editor/skin/xpressengine@default';

    /**
     * Component information
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => 'editor 기본 스킨',
        'description' => 'editor 에서 사용되는 기본 스킨입니다.'
    ];

    /**
     * View file path
     *
     * @var string
     */
    protected $path = 'editor.skin';
}
