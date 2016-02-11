<?php
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
