<?php namespace Utopigs\Localize\Models;

use Model;

class DateFormatLocale extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $guarded = ['id'];

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'utopigs_localize_dateformat_locales';

    /**
     * Validation rules
     */
    public $rules = [
        'locale' => 'required|between:2,255',
        'dateformat' => 'required|between:2,255',
        'function' => 'required|between:2,255',
    ];

    public $belongsTo = [
        'format' => [
            'Utopigs\Localize\Models\DateFormat',
            'key' => 'format_id'
        ]
    ];

    public function getFormatOrFunctionAttribute()
    {
        if ($this->is_function) {
            return $this->function;
        } else {
            return $this->dateformat;
        }
    }

    public function getLocaleOptions($value, $formData)
    {
        // october 2
        if (class_exists('\RainLab\Translate\Models\Locale')){
            $locales = \RainLab\Translate\Models\Locale::listAvailable();
        }
        // october 3
        else {
            $locales = \RainLab\Translate\Classes\Locale::listAvailable();
        }

        if (!$value) {
            $formatLocales = DateFormatLocale::where('format_id', post('format_id'))->get()->toArray();

            if (is_array($formatLocales)) {
                foreach ($formatLocales as $formats) {
                    foreach ($locales as $code => $name) {
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
            $fields->dateformat->hidden = true;
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
            unset($this->rules['dateformat']);
        }
    }

}
