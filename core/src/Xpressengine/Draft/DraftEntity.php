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
     * Convert the entity instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['etc'] = unserialize($array['etc']);

        return $array;
    }
}
