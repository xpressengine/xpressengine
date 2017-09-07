<?php
/**
 * This file is VideoMeta class
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Models\Meta;

/**
 * Class VideoMeta
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class VideoMeta extends Meta
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files_video';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'file_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'audio' => 'array',
        'video' => 'array'
    ];

    /**
     * The foreign key name for the model.
     *
     * @var string
     */
    protected $foreignKey = 'file_id';
}
