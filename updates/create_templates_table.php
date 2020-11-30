<?php namespace Dubk0ff\UniCrumbs\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTemplatesTable
 * @package Dubk0ff\UniCrumbs\Updates
 */
class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('dubk0ff_unicrumbs_templates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->text('code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dubk0ff_unicrumbs_templates');
    }
}