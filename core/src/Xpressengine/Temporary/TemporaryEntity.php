<?php
/**
 * This file is temporary entity class
 *
 * PHP version 5
 *
 * @category    Temporary
 * @package     Xpressengine\Temporary
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Temporary;

use Xpressengine\Support\Entity;

/**
 * 임시저장 데이터 객체
 *
 * @category    Temporary
 * @package     Xpressengine\Temporary
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TemporaryEntity extends Entity
{
    protected $guarded = ['id'];

    /**
     * json 으로 인코딩시 변환될 속성 값들을 반환
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $array = $this->toArray();
        $array['etc'] = unserialize($array['etc']);

        return $array;
    }
}
