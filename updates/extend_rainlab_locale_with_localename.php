<?php namespace Utopigs\Localize\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class ExtendRainlabLocalesWithLocalename extends Migration
{

    public function up()
    {
        // not needed anymore
        // if (Schema::hasColumns('rainlab_translate_locales', [
        //     'setlocale_localename',
        // ])) {
        //     return;
        // }

        // Schema::table('rainlab_translate_locales', function($table) {
        //     $table->string('setlocale_localename')->nullable();
        // });
    }

    public function down()
    {
        // october 3
        if (!Schema::hasTable('rainlab_translate_locales')) {
            return;
        }

        // october 2
        Schema::table('rainlab_translate_locales', function($table) {
            $table->dropColumn('setlocale_localename');
        });
    }

}
