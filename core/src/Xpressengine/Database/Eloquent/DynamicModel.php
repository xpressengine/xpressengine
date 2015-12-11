<?php
/**
 * DynamicModel
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Xpressengine\Database\DynamicQuery;

/**
 * DynamicModel
 *
 * * Illuminate\Database\Eloquent\Builder wrapping class
 *
*@category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class DynamicModel extends Model
{
    protected $dynamic = false;

    protected $proxyOptions = [];

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    /**
     * dynamic query 사용하도록 설정
     *
     * @param array $options proxy options
     * @return void
     */
    public function setDynamic(array $options)
    {
        $this->dynamic = true;
        $this->setProxyOptions($options);
    }

    /**
     * proxy option 설정
     *
     * @param array $options proxy options
     * @return void
     */
    public function setProxyOptions(array $options)
    {
        $this->proxyOptions = $options;
    }

    /**
     * get proxy option
     *
     * @return array
     */
    public function getProxyOptions()
    {
        return $this->proxyOptions;
    }

    /**
     * Create a new Eloquent query builder for the model.
     * Xpressengine\Database\Eloquent\Builder 울 사용하도록 변경
     *
     * @param  DynamicQuery $query dynamic query builder
     * @return \Xpressengine\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Illuminate Model 의 newBaseQueryBuilder 변경
     * VirtualConnection 을 통해 DynamicQuery 를 사용하도록 처리
     *
     * @return \Xpressengine\Database\DynamicQuery
     */
    protected function newBaseQueryBuilder()
    {
        /** @var \Xpressengine\Database\VirtualConnection $conn */
        $conn = $this->getConnection();

        $table = parent::getTable();

        if ($this->dynamic === true) {
            return $conn->dynamic($table, $this->getProxyOptions());
        } else {
            return $conn->table($table);
        }
    }
}
