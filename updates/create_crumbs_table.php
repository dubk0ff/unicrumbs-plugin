<?php namespace Dubk0ff\UniCrumbs\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateCrumbsTable
 * @package Dubk0ff\UniCrumbs\Updates
 */
class CreateCrumbsTable extends Migration
{
    public function up()
    {
        Schema::create('dubk0ff_unicrumbs_crumbs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('segment')->nullable();
            $table->string('page')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dubk0ff_unicrumbs_crumbs');
    }
}