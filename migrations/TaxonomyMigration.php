<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class TaxonomyMigration implements Migration {

    public function install()
    {
        Schema::create('taxonomy_term', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->integer('realm_id');
            $table->bigInteger('parent_id')->default(0);
            $table->string('word', 255);
            $table->string('decomposed', 255);
            $table->longText('description');
            $table->bigInteger('count')->default(0);
            $table->text('vars')->default('');
            $table->timestamps();
            $table->integer('order')->default(0);

            $table->unique(['realm_id', 'word']);
            $table->index('realm_id');
            $table->index('word');
            $table->index('decomposed');
        });

        Schema::create('taxonomy_realm', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('name', 255);
            $table->string('type');
            $table->longText('description');
            $table->bigInteger('count')->default(0);
            $table->timestamps();
            $table->unique('name');
        });

        Schema::create('taxonomy_relation', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('target_id');
            $table->bigInteger('term_id');
            $table->dateTime('created_at');
            $table->primary(['target_id', 'term_id']);
            $table->index('target_id');
            $table->index('term_id');
        });

        Schema::create('taxonomy_hierarchy', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->bigInteger('aid');
            $table->bigInteger('did');
            $table->tinyInteger('len')->default(0);
            $table->unique(['aid', 'did']);
            $table->index('aid');
            $table->index('did');
        });
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
