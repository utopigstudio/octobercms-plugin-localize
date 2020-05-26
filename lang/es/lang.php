<?php

return [
    'plugin' => [
        'name' => 'Localización',
        'description' => 'Un plugin para formatear y localizar fechas y monedas',
        'menu' => 'Localización',
    ],
    'dateformats' => [
        'menu' => 'Formatos de fecha',
        'description' => 'Gestionar formatos de fecha.',
        'single' => 'Formato de fecha',
        'list' => 'Formatos de fecha',
        'create' => 'Crear formato de fecha',
    ],
    'currencyformats' => [
        'menu' => 'Formatos de moneda',
        'description' => 'Gestionar formatos de moneda.',
        'single' => 'Formato de moneda',
        'list' => 'Formatos de moneda',
        'create' => 'Crear formato de moneda',
    ],
    'locale' => [
        'setlocale_localename' => 'Código de idioma para la localización (ex: en_US)',
    ],
    'columns' => [
        'code' => 'Código',
        'format' => 'Formato',
        'locale' => 'Código de idioma',
    ],
    'fields' => [
        'id' => 'ID',
        'code' => 'Código',
        'locale' => 'Código de idioma',
        'dateformat' => 'Formato',
        'format_locale' => 'formato localizado',
        'format_locales' => 'Formatos localitzados (por idioma)',
        'is_function' => 'Función de formato avanzada',
        'function' => 'Función',
        'no_selected' => '-- Selecciona idioma --',
        'currency_symbol' => 'Símbolo de moneda',
        'prepend_symbol' => 'El símbolo va antes que el importe',
        'sep_by_space' => 'Separar el símbolo i el importe con un espacio',
        'force_decimals' => 'Mostrar decimales siempre (aunque el importe sea redondo)',
        'decimals' => 'Cuantos decimales mostrar',
        'dec_point' => 'Indicador decimal',
        'thousands_sep' => 'Indicador de miles',
    ]
];
