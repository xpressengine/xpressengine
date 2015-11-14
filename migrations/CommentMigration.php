<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class CommentMigration implements Migration
{

    public function install()
    {
        Schema::create(
            'comments',
            function (Blueprint $table) {
                $table->engine = "InnoDB";

                $table->string('id', 36);
                $table->string('instanceId', 250); // 게시물 이동 고려
                $table->string('targetId', 36);
                $table->string('parentId', 36)->nullable();
                $table->string('userId', 36)->nullable();   // 비회원일땐 null
                $table->string('writer');
                $table->string('email')->nullable();  // 비회원 작성일때 email 받기?
                $table->string('certifyKey', 250)->nullable();
                $table->text('content');
                $table->boolean('html')->default(0);
                $table->enum('approved', ['approved', 'waiting', 'rejected'])->default('approved');
                $table->enum('display', ['visible', 'secret', 'blind', 'hidden'])->default('visible');
                $table->enum('status', ['public', 'trash'])->default('public');
                $table->boolean('removed')->default(0);
                $table->string('ip', 15);

                // 대댓글 처리를 위한 트리용 컬럼 추가 ex.) head, parent, depth
                $table->string('head', 50);    // timestamp + uuid (ex. 1430369257-bd1fc797-474f-47a6-bedb-867a376490f2)
                $table->string('reply', 200);

                $table->integer('assentCount')->default(0);
                $table->integer('dissentCount')->default(0);

                $table->timestamp('createdAt');
                $table->timestamp('updatedAt');
                $table->timestamp('publishedAt');
                $table->timestamp('deletedAt')->nullable();

                $table->primary('id');
                $table->index('targetId');
                $table->index('createdAt');
                $table->unique(['head', 'reply']);
            }
        );
    }

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'comments', 'vars' => '[]']);
    }

    public function update($currentVersion)
    {
    }

    public function checkInstall()
    {
    }

    public function checkUpdate($currentVersion)
    {
    }
}
