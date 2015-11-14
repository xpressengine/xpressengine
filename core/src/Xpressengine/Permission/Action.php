<?php
/**
 * This file is a defined actions.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Permission;

/**
 * permission 에서 체크할 action 들을 정의 함.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Action
{
    const ACCESS = 'access';

    const VISIBLE = 'visible';

    const CREATE = 'create';

    const READ = 'read';

    const UPDATE = 'update';

    const DELETE = 'delete';

    const MOVE = 'move';

    const UPLOAD = 'upload';

    const DOWNLOAD = 'download';

    /**
     * Action keyword and display name
     *
     * @var array
     */
    protected static $actions = [
        self::ACCESS => '접근',
        self::VISIBLE => '표시',
        self::CREATE => '생성',
        self::READ => '읽기',
        self::UPDATE  => '수정',
        self::DELETE  => '삭제',
        self::MOVE  => '이동',
        self::UPLOAD  => '업로드',
        self::DOWNLOAD  => '다운로드',
    ];

    /**
     * Custom actions
     *
     * @var array
     */
    protected static $customs = [];

    /**
     * Get all actions
     *
     * @return array
     */
    public static function all()
    {
        return array_merge(self::$actions, self::$customs);
    }

    /**
     * Add a custom action
     *
     * @param string $action action keyword
     * @param string $name   display name
     * @return void
     */
    public static function add($action, $name = null)
    {
        static::$customs[$action] = $name ?: $action;
    }
}
