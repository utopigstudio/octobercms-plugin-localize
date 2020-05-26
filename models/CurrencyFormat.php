<?php namespace Utopigs\Localize\Models;

use Model;
use Event;

class CurrencyFormat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $guarded = ['id'];

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'utopigs_localize_currencyformats';

    /**
     * Validation rules
     */
    public $rules = [
        'code' => 'required|between:2,255',
        'currency_symbol' => 'required|between:1,255',
        'function' => 'required|between:2,255',
    ];

    public $hasMany = [
        'format_locales' => [
            'Utopigs\Localize\Models\CurrencyFormatLocale',
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
