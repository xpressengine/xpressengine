<?php
/**
 * Document
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Document\Models;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Document
 *
 * @property string revisionId
 * @property string revisionNo
 * @property string id
 * @property string parentId
 * @property string instanceId
 * @property string type
 * @property string userId
 * @property string writer
 * @property string email
 * @property string certifyKey
 * @property string readCount
 * @property string commentCount
 * @property string assentCount
 * @property string dissentCount
 * @property string approved
 * @property string published
 * @property string status
 * @property string display
 * @property string locale
 * @property string title
 * @property string content
 * @property string pureContent
 * @property string createdAt
 * @property string publishedAt
 * @property string updatedAt
 * @property string deletedAt
 * @property string head
 * @property string reply
 * @property string listOrder
 * @property string ipaddress
 * @property string userType
 *
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
        'revisionNo', 'id', 'parentId', 'instanceId', 'userId', 'writer', 'approved',
        'published', 'status', 'display', 'locale', 'title',
        'content', 'pureContent', 'createdAt', 'publishedAt', 'head', 'reply',
        'listOrder', 'ipaddress', 'userType', 'certifyKey', 'email',
    ];

    /**
     * @var bool
     */
    protected $dynamic = true;

    /**
     * @var string
     */
    protected $primaryKey = 'revisionId';

    /**
     * user relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Xpressengine\User\Models\User', 'userId');
    }
}
