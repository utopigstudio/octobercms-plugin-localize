<?php namespace Utopigs\Localize;

use System\Classes\PluginBase;
use Backend;
use Carbon\Carbon;

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
        if (!$this->localecode) {
            $localecode = \RainLab\Translate\Classes\Translator::instance()->getLocale();
            $this->localecode = $localecode;
        }

        if ($value) {
            if (strpos($value, ':') !== false) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $value);
            } else {
                $date = Carbon::createFromFormat('Y-m-d', $value);
            }
    
            $localeFormat = $format->format_locales->firstWhere('locale', $this->localecode);
    
            $dateFormat = $localeFormat ?? $format;
    
            if ($dateFormat->function) {
                $value = eval($dateFormat->function);
                return $value;
            }
    
            return $date->locale($this->localecode)->isoFormat($dateFormat->dateformat);
        }
    }

    private function currencyformat($value, $format)
    {
        if (!$this->localecode) {
            $localecode = \RainLab\Translate\Classes\Translator::instance()->getLocale();
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

}
