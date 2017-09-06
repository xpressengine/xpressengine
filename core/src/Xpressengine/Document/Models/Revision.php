<?php
/**
 * Revision
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Document\Models;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Revision
 *
 * @property string revision_id
 * @property string revision_no
 * @property string id
 * @property string parent_id
 * @property string instance_id
 * @property string type
 * @property string user_id
 * @property string writer
 * @property string email
 * @property string certify_key
 * @property integer read_count
 * @property integer comment_count
 * @property integer assent_count
 * @property integer dissent_count
 * @property integer approved
 * @property integer published
 * @property integer status
 * @property integer display
 * @property integer format
 * @property string locale
 * @property string title
 * @property string content
 * @property string pure_content
 * @property string created_at
 * @property string published_at
 * @property string updated_at
 * @property string deleted_at
 * @property string head
 * @property string reply
 * @property string listOrder
 * @property string ipaddress
 * @property string user_type
 *
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Revision extends DynamicModel
{
    /**
     * @var string
     */
    public $table = 'documents_revision';

    /**
     * The connection name for the model.
     * Virtual connection name.
     *
     * @var string
     */
    protected $connection = 'document';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'revision_no', 'id', 'parent_id', 'instance_id', 'user_id', 'writer', 'approved',
        'published', 'status', 'display', 'locale', 'title',
        'content', 'pure_content', 'created_at', 'published_at', 'head', 'reply',
        'list_order', 'ipaddress', 'user_type', 'certify_key', 'email',
    ];

    /**
     * @var bool
     */
    protected $dynamic = true;

    /**
     * @var string
     */
    protected $primaryKey = 'revision_id';

    /**
     * user relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Xpressengine\User\Models\User', 'user_id');
    }
}
