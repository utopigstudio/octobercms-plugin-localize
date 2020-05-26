<?php namespace Utopigs\Localize\Updates;

use Schema;
use DB;
use October\Rain\Database\Updates\Migration;

class CreateDateformatsTables extends Migration
{

    public function up()
    {
        Schema::dropIfExists('utopigs_localize_dateformat_locales');
        Schema::dropIfExists('utopigs_localize_dateformats');

        Schema::create('utopigs_localize_dateformats', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('code')->nullable()->index();

            $table->string('dateformat')->nullable();

            $table->boolean('is_function')->default(false);
            $table->string('function')->nullable();

            $table->timestamps();
        });

        Schema::create('utopigs_localize_dateformat_locales', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('format_id')->unsigned()->nullable()->index();
            $table->string('locale')->nullable();

            $table->string('dateformat')->nullable();

            $table->boolean('is_function')->default(false);
            $table->string('function')->nullable();

            $table->timestamps();
        });

        $default_formats = [
            'short' => '%e %b %Y',
            'long' => '%A %e %b %Y',
            'time' => '%H:%M',
            'short_time' => '%e %b %Y - %H:%M',
            'long_time' => '%A %e %b %Y - %H:%M',
        ];

        foreach ($default_formats as $code => $format) {
            \Utopigs\Localize\Models\DateFormat::create([
                'code' => $code,
                'dateformat' => $format,
            ]);
        }

        \Utopigs\Localize\Models\DateFormat::create([
            'code' => 'advanced',
            'is_function' => true,
            'function' => 'return $date->format(\'jS F Y\');'
        ]);

    }

    public function down()
    {
        Schema::dropIfExists('utopigs_localize_dateformat_locales');
        Schema::dropIfExists('utopigs_localize_dateformats');
    }

}
