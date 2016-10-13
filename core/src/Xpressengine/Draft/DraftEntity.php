<?php
/**
 * This file is draft entity class
 *
 * PHP version 5
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Draft;

use Xpressengine\Support\Entity;

/**
 * 임시저장 데이터 객체
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DraftEntity extends Entity
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
