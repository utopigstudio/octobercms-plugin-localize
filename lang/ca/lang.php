<?php

return [
    'plugin' => [
        'name' => 'Localització',
        'description' => 'Un plugin per formatejar i localitzar dates i monedes',
        'menu' => 'Localització',
    ],
    'dateformats' => [
        'menu' => 'Formats de data',
        'description' => 'Gestionar formats de data.',
        'single' => 'Format de data',
        'list' => 'Formats de data',
        'create' => 'Crear format de data',
    ],
    'currencyformats' => [
        'menu' => 'Formats de moneda',
        'description' => 'Gestionar formats de moneda.',
        'single' => 'Format de moneda',
        'list' => 'Formats de moneda',
        'create' => 'Crear format de moneda',
    ],
    'locale' => [
        'setlocale_localename' => 'Codi d’idioma per la localització (ex: en_US)',
    ],
    'columns' => [
        'code' => 'Codi',
        'format' => 'Format',
        'locale' => 'Codi d’idioma',
    ],
    'fields' => [
        'id' => 'ID',
        'code' => 'Codi',
        'locale' => 'Codi d’idioma',
        'dateformat' => 'Format',
        'format_locale' => 'format localitzat',
        'format_locales' => 'Formats localitzats (per idioma)',
        'is_function' => 'Funció de format avançada',
        'function' => 'Funció',
        'no_selected' => '-- Selecciona idioma --',
        'currency_symbol' => 'Símbol de moneda',
        'prepend_symbol' => 'El símbol va abans que l’import',
        'sep_by_space' => 'Separar el símbol i l’import amb un espai',
        'force_decimals' => 'Mostrar decimals sempre (encara que l’import sigui rodó)',
        'decimals' => 'Quants decimals mostrar',
        'dec_point' => 'Indicador decimal',
        'thousands_sep' => 'Indicador de milers',
    ]
];
