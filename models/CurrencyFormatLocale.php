<?php namespace Utopigs\Localize\Models;

use Model;
use RainLab\Translate\Models\Locale;

class CurrencyFormatLocale extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $guarded = ['id'];

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'utopigs_localize_currencyformat_locales';

    /**
     * Validation rules
     */
    public $rules = [
        'locale' => 'required|between:2,255',
        'currency_symbol' => 'required|between:1,255',
        'function' => 'required|between:2,255',
    ];

    public $belongsTo = [
        'format' => [
            'Utopigs\Localize\Models\CurrencyFormat',
            'key' => 'format_id'
        ]
    ];

    public function getFormatOrFunctionAttribute()
    {
        if ($this->is_function) {
            return $this->function;
        } else {
            $value_f = number_format('99.99', $this->decimals, $this->dec_point, $this->thousands_sep);

            if ($this->prepend_symbol) {
                $value_f = $this->currency_symbol . ($this->sep_by_space ? ' ' : '') . $value_f;
            } else {
                $value_f = $value_f . ($this->sep_by_space ? ' ' : '') . $this->currency_symbol;
            }
    
            return $value_f;
        }
    }

    public function getLocaleOptions($value, $formData)
    {
        $locales = Locale::lists('code', 'code');
        if (!$value) {
            $formatLocales = CurrencyFormatLocale::where('format_id', post('format_id'))->get()->toArray();

            if (is_array($formatLocales)) {
                foreach ($formatLocales as $formats) {
                    foreach ($locales as $code) {
                        if ($formats['locale'] == $code) {
                            unset($locales[$code]);
                        }
                    }
                }
            }
            return $locales;
        }
        return $locales;
    }

    public function filterFields($fields, $context = null)
    {
        if (!$this->is_function) {
            $fields->function->hidden = true;
        }

        if ($this->is_function) {
            $fields->currency_symbol->hidden = true;
            $fields->prepend_symbol->hidden = true;
            $fields->force_decimals->hidden = true;
            $fields->decimals->hidden = true;
            $fields->sep_by_space->hidden = true;
            $fields->dec_point->hidden = true;
            $fields->thousands_sep->hidden = true;
        }

        if ($context == 'update') {
            $fields->locale->disabled = true;
            $fields->locale->filter = false;
        }
    }

    public function beforeValidate()
    {
        if ($this->is_function == false) {
            unset($this->rules['function']);
        } else {
            unset($this->rules['currency_symbol']);
        }

    }

}
