<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Schema;
use DB;
use Xpressengine\Document\Models\Document;
use Xpressengine\Support\Migration;

class DocumentMigration extends Migration
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
            // global documents table
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('document ID');
            $table = $this->setColumns($table);

            $table->index('created_at');
            $table->unique(['head', 'reply']);
            $table->primary(array('id'));
        });

        if ($revision != '') {
            // create revision table
            Schema::create($revision, function (Blueprint $table) {
                // documents update log
                $table->engine = "InnoDB";

                $table->string('revision_id', 36)->comment('revision ID');
                $table->integer('revision_no')->default(0)->comment('revision version number. It starts with 0 and increases when added.');

                $table->string('id', 36)->comment('document ID');
                $table = $this->setColumns($table);

                $table->index('created_at');
                $table->primary(array('revision_id'));
                $table->index(array('id', 'revision_no'));
            });
        }
    }

    /**
     *
     */
    public function createDivision(Builder $schema, $table)
    {
        $schema->create($table, function (Blueprint $table) {
            // division table of documents. Same documents exist in global documents table.
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table = $this->setColumns($table);

            $table->index('created_at');
            $table->unique(['head', 'reply']);
            $table->primary(array('id'));
        });
    }

    /**
     * @param Blueprint $table table
     * @return Blueprint
     */
    private function setColumns(Blueprint $table)
    {
        $table->string('parent_id', 36)->default('')->comment('parent document ID');

        $table->string('instance_id', 36)->default('')->comment('instance ID. This is associated with area classification as like Menu, Board.');
        $table->string('type', 36)->default('')->comment('Module Type. Module ID of registered this document.');

        // users
        $table->string('user_type', '16')->default('normal')->comment('User Type. Type of document writer. user/guest/anonymity/normal');
        $table->string('user_id', 36)->comment('User ID. User ID of document writer. If userType is guest or anonymity it can be empty string.');
        $table->string('writer', 200)->comment('document writer name. It is usually a User displayName. It can be differ if userType is guest or anonymity.');
        $table->string('email')->nullable()->comment('Email. It is usually Null. It registered if userType is guest.');
        $table->string('certify_key', 200)->comment('Certify key. It is usually empty string. It registered if userType is guest.');

        // count
        $table->integer('read_count')->default(0)->comment('document read count');
        $table->integer('comment_count')->default(0)->comment('commented registered counter');
        $table->integer('assent_count')->default(0)->comment('assent count. The count for assent type.');
        $table->integer('dissent_count')->default(0)->comment('dissent count. The count for dissent type.');

        // display contents config values
        $table->integer('approved')->default(Document::APPROVED_APPROVED)->comment('approved status. 0:rejected/10:waiting/30:approved');
        $table->integer('published')->default(Document::PUBLISHED_PUBLISHED)->comment('published status. 0:rejected/10:waiting/20:reserved/30:published');
        $table->integer('status')->default(Document::STATUS_PUBLIC)->comment('document status. 0:trash/10:temporary/20:private/30:public/50:notice');
        $table->integer('display')->default(Document::DISPLAY_VISIBLE)->comment('display status. 0:hidden/10:secret/20:visible');
        $table->integer('format')->default(Document::FORMAT_HTML)->comment('document content format. 0:none/10:HTML');

        // search
        $table->string('locale', 4)->default('')->comment('locale information. Empty string if not set. ko:korean/en:english/...');

        $table->string('title', 180)->comment('document title');
        $table->text('content')->comment('document content');
        $table->text('pure_content')->comment('document pure content. There is content for human readable(HTML removed). It using for fulltext search.');

        $table->timestamp('created_at')->comment('document created date');
        $table->timestamp('updated_at')->comment('document updated date');
        $table->timestamp('published_at')->nullable()->comment('document published date');
        $table->timestamp('deleted_at')->nullable()->comment('document deleted date. for soft delete.');

        $table->string('head', 50)->comment('document order. It using for document list sorting. Enables sorting of parent-child relationship documents.');
        $table->string('reply', 150)->comment('string for sorting parent-child documents');
        $table->string('ipaddress', 16)->comment('IP address of document writer');

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
}
