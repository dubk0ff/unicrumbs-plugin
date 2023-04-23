<?php namespace Dubk0ff\UniCrumbs\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dubk0ff_unicrumbs_crumbs', function(Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->string('type_value')->after('title');
            $table->dropColumn(['link', 'segment', 'page']);
        });
    }

    public function down(): void
    {
        Schema::table('dubk0ff_unicrumbs_crumbs', function(Blueprint $table) {
            $table->string('link')->nullable()->after('title');
            $table->string('segment')->nullable()->after('link');
            $table->string('page')->nullable()->after('segment');
            $table->dropColumn('type_value');
        });
    }
};
