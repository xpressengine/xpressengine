<?php
/**
 * Site
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site;

use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Site
 *
 * @category    Site
 * @package     Xpressengine\Site
 *
 * @property string $host           지정된 도메인
 * @property string $siteKey        고유한 식별자
 */

class Site extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'siteKey';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
