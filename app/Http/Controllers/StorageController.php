<?php
/**
 * StorageController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XeStorage;

/**
 * Class StorageController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class StorageController extends Controller
{
    /**
     * Show file contents.
     *
     * @param string $id identifier
     * @return string
     */
    public function file($id)
    {
        $file = XeStorage::find($id);

        header('Content-type: ' . $file->mime);

        echo $file->getContent();
    }
}
