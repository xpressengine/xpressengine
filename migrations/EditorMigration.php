<?php
/**
 * EditorMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Xpressengine\Editor\EditorHandler;
use Xpressengine\Permission\Grant;
use Xpressengine\Support\Migration;
use Xpressengine\User\Rating;

/**
 * Class EditorMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class EditorMigration extends Migration
{

    /**
     * Run after service activation.
     *
     * @return void
     */
    public function init()
    {
        app('xe.config')->set(EditorHandler::CONFIG_NAME, [
            'height' => 400,
            'fontSize' => '14px',
            'fontFamily' => null,
            'uploadActive' => true,
            'fileMaxSize' => 2,
            'attachMaxSize' => 10,
            'extensions' => '*',
            'tools' => []
        ]);

        $data = [
            Grant::RATING_TYPE => Rating::USER,
            Grant::GROUP_TYPE => [],
            Grant::USER_TYPE => [],
            Grant::EXCEPT_TYPE => [],
            Grant::VGROUP_TYPE => [],
        ];

        $grant = new Grant();
        $grant->set('html', $data);
        $grant->set('tool', $data);
        $grant->set('upload', $data);
        $grant->set('download', $data);
        app('xe.permission')->register(EditorHandler::CONFIG_NAME, $grant);
    }
}
