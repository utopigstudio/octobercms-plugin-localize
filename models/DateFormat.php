<?php namespace Utopigs\Localize\Models;

use Model;
use Event;

class DateFormat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $guarded = ['id'];

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'utopigs_localize_dateformats';

    /**
     * Validation rules
     */
    public $rules = [
        'code' => 'required|between:2,255',
        'dateformat' => 'required|between:2,255',
        'function' => 'required|between:2,255',
    ];

    public $hasMany = [
        'format_locales' => [
            'Utopigs\Localize\Models\DateFormatLocale',
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

    public function filterFields($fields, $context = null)
    {
        if (!$this->is_function) {
            $fields->function->hidden = true;
        }

        if ($this->is_function) {
            $fields->dateformat->hidden = true;
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
