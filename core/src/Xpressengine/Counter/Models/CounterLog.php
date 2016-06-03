<?php
/**
 * CounterLog
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Counter\Models;

use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * CounterLog
 *
 * @property string id
 * @property string counterName
 * @property string counterOption
 * @property string targetId
 * @property string userId
 * @property integer point
 * @property string ipaddress
 * @property string createdAt
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 */
class CounterLog extends DynamicModel
{
    /**
     * @var string
     */
    protected $table = 'counter_log';

    /**
     * User relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('Xpressengine\User\Models\User', 'id', 'userId');
    }

    /**
     * updatedAt column 없음
     *
     * @param mixed $value value
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        return $this;
    }
}
