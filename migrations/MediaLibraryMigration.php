<?php

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;

use Xpressengine\MediaLibrary\Models\MediaLibraryFolder;
use Xpressengine\Support\Migration;
use Schema;

class MediaLibraryMigration extends Migration
{
    private $fileTableName = 'media_library_files';
    private $folderTableName = 'media_library_folders';
    private $closureTableName = 'media_library_folder_closure';

    /**
     * 서비스에 필요한 자체 환경(타 서비스와 연관이 없는 환경)을 구축한다.
     * 서비스의 db table 생성과 같은 migration 코드를 작성한다.
     *
     * @return mixed
     */
    public function install()
    {
        $this->createTables();
    }

    /**
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {

    }

    /**
     * 서비스가 구동된 이후에 실행되므로 다양한 서비스를 사용하여 코드를 작성할 수 있다.
     *
     * @return void
     */
    public function init()
    {
        if ($this->checkExistRootFolder() == false) {
            $this->storeRootFolder();
        }
    }

    /**
     * 서비스가 구동되는데에 직접적인 연관은 없으나, XE 설치후 기본적인 메뉴구성이나 컨텐츠를 구성하는 코드를 작성한다.
     *
     * @return void
     */
    public function initialized()
    {

    }

    /**
     * 서비스가 업데이트되었을 경우, update()메소드를 실행해야 하는지의 여부를 체크한다.
     * update()메소드를 실행해야 한다면 false를 반환한다.
     *
     * @param string $installedVersion current version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        if ($this->checkExistTables() == false) {
            return false;
        }

        if ($this->checkExistRootFolder() == false) {
            return false;
        }

        return true;
    }

    /**
     * update 코드를 실행한다.
     *
     * @param string $installedVersion current version
     *
     * @return mixed
     */
    public function update($installedVersion = null)
    {
        if ($this->checkExistTables() == false) {
            $this->createTables();
        }

        if ($this->checkExistRootFolder() == false) {
            $this->storeRootFolder();
        }
    }

    private function checkExistTables()
    {
        return Schema::hasTable($this->fileTableName) &&
            Schema::hasTable($this->folderTableName) &&
            Schema::hasTable($this->closureTableName);
    }

    private function createTables()
    {
        if (Schema::hasTable($this->fileTableName) == false) {
            Schema::create($this->fileTableName, function (Blueprint $table) {
                $table->string('id', 36);

                $table->string('file_id', 36);
                $table->string('folder_id', 36);
                $table->string('user_id', 36)->nullable();
                $table->string('title')->nullable();
                $table->string('ext')->nullable();
                $table->string('caption')->nullable();
                $table->string('alt_text')->nullable();
                $table->text('description')->nullable();

                $table->timestamps();

                $table->primary('id');
                $table->index('folder_id');
            });
        }

        if (Schema::hasTable($this->folderTableName) == false) {
            Schema::create($this->folderTableName, function (Blueprint $table) {
                $table->string('id', 36);

                $table->string('parent_id', 36);
                $table->string('disk');
                $table->string('name');
                $table->integer('ordering');

                $table->timestamps();

                $table->index('id');
            });
        }

        if (Schema::hasTable($this->closureTableName) == false) {
            Schema::create($this->closureTableName, function (Blueprint $table) {
                $table->increments('id');

                $table->string('ancestor', 36);
                $table->string('descendant', 36);
                $table->integer('depth');

                $table->index('ancestor');
                $table->index('descendant');
            });
        }
    }

    private function checkExistRootFolder()
    {
        return \DB::table($this->folderTableName)->where('name', '/')->exists();
    }

    private function storeRootFolder()
    {
        $rootFolderAttributes = [
            'parent_id' => '',
            'disk' => 'media',
            'name' => '/',
            'ordering' => 0
        ];

        $rootFolderModel = new MediaLibraryFolder();
        $rootFolderModel->fill($rootFolderAttributes);
        $rootFolderModel->save();

        $rootFolderModel->ancestors()->attach($rootFolderModel->getKey(), [$rootFolderModel->getDepthName() => 0]);
    }
}
