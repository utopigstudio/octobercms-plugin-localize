<?php namespace Utopigs\Localize\Updates;

use Schema;
use DB;
use October\Rain\Database\Updates\Migration;

class CreateCurrencyformatsTables extends Migration
{

    public function up()
    {
        Schema::dropIfExists('utopigs_localize_currencyformats');

        Schema::create('utopigs_localize_currencyformats', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('code')->nullable()->index();

            $table->string('currency_symbol')->default('$');
            $table->boolean('prepend_symbol')->default(true);
            $table->boolean('sep_by_space')->default(false);
            $table->integer('decimals')->default(2);
            $table->boolean('force_decimals')->default(true);
            $table->string('dec_point')->default('.');
            $table->string('thousands_sep')->default(',');

            $table->boolean('is_function')->default(false);
            $table->string('function')->nullable();

            $table->timestamps();
        });

        Schema::create('utopigs_localize_currencyformat_locales', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('format_id')->unsigned()->nullable()->index();
            $table->string('locale')->nullable();

            $table->string('currency_symbol')->default('$');
            $table->boolean('prepend_symbol')->default(true);
            $table->boolean('sep_by_space')->default(false);
            $table->integer('decimals')->default(2);
            $table->boolean('force_decimals')->default(true);
            $table->string('dec_point')->default('.');
            $table->string('thousands_sep')->default(',');

            $table->boolean('is_function')->default(false);
            $table->string('function')->nullable();

            $table->timestamps();
        });

        $default_formats = [
            'default' => [
                'currency_symbol' => '€',
                'prepend_symbol' => false,
                'sep_by_space' => true,
                'decimals' => 2,
                'force_decimals' => true,
                'dec_point' => ',',
                'thousands_sep' => '.',
            ],
        ];

        foreach ($default_formats as $code => $format) {
            $format['code'] = $code;
            \Utopigs\Localize\Models\CurrencyFormat::create($format);
        }

    }

    public function down()
    {
        Schema::dropIfExists('utopigs_localize_currencyformats');
    }

}
