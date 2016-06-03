<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Storage\File;

class StorageController extends Controller
{
    public function file($id)
    {
        $file = File::find($id);

        header('Content-type: ' . $file->mime);

        echo $file->getContent();
    }
}
