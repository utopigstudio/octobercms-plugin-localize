<?php namespace Utopigs\Localize\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class ConvertDateformats extends Migration
{

    public function up()
    {
        $formats = \Utopigs\Localize\Models\DateFormat::all();
        $phpformats = ['%a',  '%A',   '%d', '%e', '%j',   '%u', '%w', '%U', '%V', '%W', '%b',  '%B',   '%h',  '%m', '%C', '%g', '%G', '%y', '%Y',   '%H', '%k', '%I', '%l', '%M', '%p', '%P', '%r',         '%R',    '%S', '%T',       '%X', '%z', '%Z', '%c',   '%D', '%F',         '%s', '%x', '%n', '%t', '%%'];
        $mjsformats = ['ddd', 'dddd', 'MM', 'M',  'DDDD', 'E',  'd',  'ww', 'W',  'WW', 'MMM', 'MMMM', 'MMM', 'MM', '',   '',   '',   'YY', 'YYYY', 'HH', 'H',  'hh', 'h',  'mm', 'A',  'a',  'hh:mm:ss A', 'HH:mm', 'ss', 'HH:mm:ss', 'LTS', 'Z', 'z',  'llll', 'L',  'YYYY-MM-DD', 'X',  'L',  '',   '',   '%' ];
 
        foreach ($formats as $format) {
            $dateformat = $format->dateformat;
            $dateformat = str_replace($phpformats, $mjsformats, $dateformat);
            $format->dateformat = $dateformat;
            $format->save();

            foreach ($format->format_locales as $format_locale) {
                $dateformat = $format_locale->dateformat;
                $dateformat = str_replace($phpformats, $mjsformats, $dateformat);
                $format_locale->dateformat = $dateformat;
                $format_locale->save();
            }
        }
    }

    public function down()
    {
        $formats = \Utopigs\Localize\Models\DateFormat::all();
        $phpformats = ['%a',  '%A',   '%d', '%e', '%j',   '%u', '%w', '%U', '%V', '%W', '%b',  '%B',   '%h',  '%m', '%C', '%g', '%G', '%y', '%Y',   '%H', '%k', '%I', '%l', '%M', '%p', '%P', '%r',         '%R',    '%S', '%T',       '%X', '%z', '%Z', '%c',   '%D', '%F',         '%s', '%x', '%n', '%t', '%%'];
        $mjsformats = ['ddd', 'dddd', 'MM', 'M',  'DDDD', 'E',  'd',  'ww', 'W',  'WW', 'MMM', 'MMMM', 'MMM', 'MM', '',   '',   '',   'YY', 'YYYY', 'HH', 'H',  'hh', 'h',  'mm', 'A',  'a',  'hh:mm:ss A', 'HH:mm', 'ss', 'HH:mm:ss', 'LTS', 'Z', 'z',  'llll', 'L',  'YYYY-MM-DD', 'X',  'L',  '',   '',   '%' ];

        foreach ($formats as $format) {
            $dateformat = $format->dateformat;
            $dateformat = str_replace($mjsformats, $phpformats, $dateformat);
            $format->dateformat = $dateformat;
            $format->save();

            foreach ($format->format_locales as $format_locale) {
                $dateformat = $format_locale->dateformat;
                $dateformat = str_replace($mjsformats, $phpformats, $dateformat);
                $format_locale->dateformat = $dateformat;
                $format_locale->save();
            }
        }
    }

}
