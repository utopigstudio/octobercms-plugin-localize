<?php namespace Utopigs\Localize;

use System\Classes\PluginBase;
use Backend;
use Carbon\Carbon;
use Yaml;
use File;

/**
 * Localize Plugin Information File
 */
class Plugin extends PluginBase
{
    private $localecode;

    private $localename;

    /**
     * @var array Plugin dependencies
     */
    public $require = ['RainLab.Translate'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'utopigs.localize::lang.plugin.name',
            'description' => 'utopigs.localize::lang.plugin.description',
            'author' => 'Utopig Studio',
            'icon' => 'icon-language',
            'homepage'    => 'https://github.com/utopigstudio/octobercms-plugin-localize'
        ];
    }

    public function registerSettings()
    {
        return [
            'localize_dateformats' => [
                'label'       => 'utopigs.localize::lang.dateformats.menu',
                'description' => 'utopigs.localize::lang.dateformats.description',
                'icon'        => 'icon-language',
                'url'         => Backend::url('utopigs/localize/dateformats'),
                'order'       => 551,
                'category'    => 'utopigs.localize::lang.plugin.menu',
                'permissions' => ['utopigs.localize.manage_locales']
            ],
            'localize_currencyformats' => [
                'label'       => 'utopigs.localize::lang.currencyformats.menu',
                'description' => 'utopigs.localize::lang.currencyformats.description',
                'icon'        => 'icon-language',
                'url'         => Backend::url('utopigs/localize/currencyformats'),
                'order'       => 552,
                'category'    => 'utopigs.localize::lang.plugin.menu',
                'permissions' => ['utopigs.localize.manage_locales']
            ]
        ];
    }

    public function registerListColumnTypes()
    {
        $filters = [];

        $filters = $this->getFormats();

        return $filters;
    }

    public function registerMarkupTags()
    {
        $filters = $this->getFormats();

        return ['filters' => $filters];
    }

    private function getFormats()
    {
        $filters = [];

        $formats = \Utopigs\Localize\Models\DateFormat::with('format_locales')->get();
        foreach ($formats as $format) {
            $filters['dateformat_'.$format->code] = function ($value) use ($format) {
                $localizedDate = $this->dateformat($value, $format);
                return $localizedDate;
            };
        }

        $formats = \Utopigs\Localize\Models\CurrencyFormat::with('format_locales')->get();
        foreach ($formats as $format) {
            $filters['currencyformat_'.$format->code] = function ($value) use ($format) {
                $localizedCurrency = $this->currencyformat($value, $format);
                return $localizedCurrency;
            };
        }

        if (isset($filters['currencyformat_default'])) {
            $filters['currencyformat'] = $filters['currencyformat_default'];
        } else {
            $format = new \Utopigs\Localize\Models\CurrencyFormat([
                'decimals' => 2,
                'dec_point' => '.',
                'thousands_sep' => ',',
                'currency_symbol' => '€',
                'sep_by_space' => true,
                'prepend_symbol' => false,
            ]);
            $filters['currencyformat'.$format->code] = function ($value) use ($format) {
                $localizedCurrency = $this->currencyformat($value, $format);
                return $localizedCurrency;
            };
        }

        return $filters;
    }

    private function dateformat($value, $format)
    {
        if (!$this->localename) {
            $localecode = \RainLab\Translate\Classes\Translator::instance()->getLocale();
            $locale = \RainLab\Translate\Models\Locale::findByCode($localecode);
            $this->localename = $locale->setlocale_localename ?? $localecode;
            $this->localecode = $localecode;
        }

        $date = $this->localize($value);

        $localeFormat = $format->format_locales->firstWhere('locale', $this->localecode);

        $dateFormat = $localeFormat ?? $format;

        if ($dateFormat->function) {
            $value = eval($dateFormat->function);
            return $value;
        }

        return $date->formatLocalized($dateFormat->dateformat);
    }

    private function currencyformat($value, $format)
    {
        if (!$this->localename) {
            $localecode = \RainLab\Translate\Classes\Translator::instance()->getLocale();
            $locale = \RainLab\Translate\Models\Locale::findByCode($localecode);
            $this->localename = $locale->setlocale_localename ?? $localecode;
            $this->localecode = $localecode;
        }

        $localeFormat = $format->format_locales->firstWhere('locale', $this->localecode);

        $currencyFormat = $localeFormat ?? $format;

        if ($currencyFormat->function) {
            $value = eval($currencyFormat->function);
            return $value;
        }

        $value_f = number_format($value, $format->decimals, $format->dec_point, $format->thousands_sep);

        if ($format->prepend_symbol) {
            $value_f = $format->currency_symbol . ($format->sep_by_space ? ' ' : '') . $value_f;
        } else {
            $value_f = $value_f . ($format->sep_by_space ? ' ' : '') . $format->currency_symbol;
        }

        return $value_f;
    }

    private function localize($date)
    {
        if (strpos($date, ':') !== false) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        } else {
            $date = Carbon::createFromFormat('Y-m-d', $date);
        }

        setlocale(LC_TIME, $this->localename);
        Carbon::setUtf8(true);

        return $date;
    }

    public function boot()
    {
        $this->bootTranslateExtend();
    }

    /**
     * Extend translate plugin
     */
    private function bootTranslateExtend()
    {
        if (class_exists("\RainLab\Translate\Models\Locale")) {

            \RainLab\Translate\Models\Locale::extend(function($model) {
                //add fields
                $model->addFillable([
                    'setlocale_localename'
                ]);
            });

            //extend backend form with new fields
            \Rainlab\Translate\Controllers\Locales::extendFormFields(function($widget) {
                // Prevent extending of related form instead of the intended form
                // prevent extending repeater fields
                if (!$widget->model instanceof \RainLab\Translate\Models\Locale || $widget->isNested) {
                    return;
                }

                $configFile = __DIR__ . '/models/locale/fields.yaml';
                $config = Yaml::parse(File::get($configFile));
                $widget->addFields($config);
            });
        }
    }

}
