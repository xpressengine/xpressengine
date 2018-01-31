<?php
/**
 * Term.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Models;


use Xpressengine\Database\Eloquent\DynamicModel;

class Term extends DynamicModel
{
    protected $table = 'user_terms';

    protected $fillable = ['key', 'locale', 'title', 'content', 'order', 'is_enabled'];

    protected $casts = ['is_enabled' => 'bool'];

    public $incrementing = false;

    public $timestamps = false;
}
