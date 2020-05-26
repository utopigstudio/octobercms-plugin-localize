<?php

return [
    'plugin' => [
        'name' => 'Localization',
        'description' => 'A plugin to format and localize dates and currencies',
        'menu' => 'Localization',
    ],
    'dateformats' => [
        'menu' => 'Date formats',
        'description' => 'Manage date formats.',
        'single' => 'Date format',
        'list' => 'Date formats',
        'create' => 'Create date format',
    ],
    'currencyformats' => [
        'menu' => 'Currency formats',
        'description' => 'Manage currency formats.',
        'single' => 'Currency format',
        'list' => 'Currency formats',
        'create' => 'Create currency format',
    ],
    'locale' => [
        'setlocale_localename' => 'Language code for the localization (ex: en_US)',
    ],
    'columns' => [
        'code' => 'Code',
        'format' => 'Format',
        'locale' => 'Language code',
    ],
    'fields' => [
        'id' => 'ID',
        'code' => 'Code',
        'locale' => 'Language code',
        'dateformat' => 'Format',
        'format_locale' => 'localized format',
        'format_locales' => 'Localized formats (by language)',
        'is_function' => 'Advanced format function',
        'function' => 'Function',
        'no_selected' => '-- Select language --',
        'currency_symbol' => 'Currency symbol',
        'prepend_symbol' => 'Prepend symbol',
        'sep_by_space' => 'Separate symbol and number with a space',
        'force_decimals' => 'Show decimals always (even if number is round)',
        'decimals' => 'How many decimals to show',
        'dec_point' => 'Decimal point',
        'thousands_sep' => 'Thousands separator',
    ]
];
