<?php
namespace App\Http\Controllers;

use App;
use Input;
use Presenter;

class StorageController extends Controller
{
    /**
     * @var \Xpressengine\Storage\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->storage = App::make('xe.storage');
    }

    public function file($id)
    {
        $file = $this->storage->get($id);

        header('Content-type: ' . $file->mime);

        echo $this->storage->read($file);
    }

    // 이하 관리자
    public function index()
    {
        $files = $this->storage->paginate(['parentId' => null]);

        return Presenter::make('storage.index', compact('files'));
    }

    public function destroy()
    {
        $ids = Input::get('id');
        $files = $this->storage->getsIn($ids);
        foreach ($files as $file) {
            $this->storage->remove($file);
        }

        if (Input::get('redirect') != null) {
            return redirect(Input::get('redirect'));
        } else {
            return redirect()->route('manage.storage.index');
        }
    }


}
