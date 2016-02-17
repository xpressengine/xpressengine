<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Schema;
use DB;
use Xpressengine\Support\Migration;

class DocumentMigration implements Migration
{
    /**
     * install
     *
     * @return void
     */
    public function install()
    {
        $this->create('documents', 'documents_revision');
    }

    public function create($table, $revision = '')
    {
        // create documents table
        Schema::create($table, function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 255);
            $table = $this->setColumns($table);

            $table->primary(array('id'));
        });

        if ($revision != '') {
            // create revision table
            Schema::create($revision, function (Blueprint $table) {
                $table->engine = "InnoDB";

                $table->string('revisionId', 255);
                $table->integer('revisionNo')->default(0);

                $table->string('id', 255);
                $table = $this->setColumns($table);

                $table->primary(array('revisionId'));
                $table->index(array('id', 'revisionNo'));
                $table->dropUnique('documents_revision_head_reply_unique');
            });
        }
    }

    /**
     *
     */
    public function createDivision(Builder $schema, $table)
    {
        $schema->create($table, function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 255);
            $table = $this->setColumns($table);

            $table->primary(array('id'));
        });
    }

    /**
     * @param Blueprint $table table
     * @return Blueprint
     */
    private function setColumns(Blueprint $table)
    {
        $table->string('parentId', 255)->default('');

        $table->string('instanceId', 255)->default('');

        // users
        $table->string('userType', '16')->default('normal');
        $table->string('userId', 255);
        $table->string('writer', 255);
        $table->string('email')->nullable();  // 비회원 작성일때 email 받기?
        $table->string('certifyKey', 255); // nonmember document's password

        // count
        $table->integer('readCount')->default(0);
        $table->integer('commentCount')->default(0);
        $table->integer('assentCount')->default(0);
        $table->integer('dissentCount')->default(0);

        // display contents config values
        $table->enum('approved', array(
            'approved', 'waiting', 'rejected',
        ))->default('approved');
        $table->enum('published', array(
            'published', 'waiting', 'reserved', 'rejected',
        ))->default('published');
        $table->enum('status', array(
            'public', 'temp', 'trash', 'private', 'notice',
        ))->default('public');
        $table->enum('display', array(
            'visible', 'secret', 'hidden',
        ))->default('visible');

        // search
        $table->string('locale', 255)->default('');

        $table->string('title', 255);
        $table->text('content');
        $table->text('pureContent');

        $table->timestamp('createdAt');
        $table->timestamp('publishedAt');
        $table->timestamp('updatedAt');
        $table->timestamp('deletedAt')->nullable();

        $table->string('head', 50);    // timestamp + uuid (ex. 1430369257-bd1fc797-474f-47a6-bedb-867a376490f2)
        $table->string('reply', 200);
        //$table->string('listOrder', 250);
        $table->string('ipaddress', 16);

        $table->index('createdAt');
        $table->unique(['head', 'reply']);

        return $table;
    }

    /**
     * seeding
     *
     * @return void
     */
    public function installed()
    {
        DB::table('config')->insert([
            'name' => 'document',
            'vars' => '{"instanceId":0,"instanceName":0,"division":false,"revision":false,"comment":true,"assent":true,"nonmember":false,"reply":false}'
        ]);
    }

    /**
     * update
     *
     * @param string $currentVersion version
     * @return void
     */
    public function update($currentVersion)
    {

    }

    /**
     * check install
     *
     * @return void
     */
    public function checkInstall()
    {
    }

    /**
     * check update
     *
     * @param string $currentVersion version
     * @return void
     */
    public function checkUpdate($currentVersion)
    {
    }
}
