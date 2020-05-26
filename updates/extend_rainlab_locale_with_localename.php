<?php namespace Utopigs\Localize\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use RainLab\Translate\Models\Locale;

class ExtendRainlabLocalesWithLocalename extends Migration
{

    public function up()
    {
        if (Schema::hasColumns('rainlab_translate_locales', [
            'setlocale_localename',
        ])) {
            return;
        }

        Schema::table('rainlab_translate_locales', function($table) {
            $table->string('setlocale_localename')->nullable();
        });

    }

    public function down()
    {
        Schema::table('rainlab_translate_locales', function($table) {
            $table->dropColumn('setlocale_localename');
        });
    }

}
