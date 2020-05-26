# Localize Plugin

This plugin allows to create different formats for dates and currencies. The formats can be used on the themes or on the backend.

It needs [Rainlab Translate](http://octobercms.com/plugin/rainlab-translate) plugin to work.

You don't need to add any component in your theme. The plugin automatically creates filters that you can use in your pages and partials.

## Mapping language codes to correct system locale codes

The plugin extends the Rainlab Translate locales with another field that you can use to map the existing locales to the locales in your system, so the date format functions can work. For example, you could map your page locales like this:

    en -> en_UK
    es -> es_ES
    fr -> fr_FR

This can be done from the "Manage languages" section in Translate plugin settings.

## Creating formats

The date and currency formats are managed from the plugin settings. Some examples are automatically created.

You need to create a generic format for all locales, and you can create a specific format for each different locale.

You can use your formats from your twig pages and partials like this:

    {{ date_field|dateformat_short }}

    {{ price_field|currencyformat_euro }}

And from the backend lists like this:

    columns:
        price:
            label: 'Date'
            type: dateformat_short

    columns:
        price:
            label: 'Product price'
            type: currencyformat_euro

### Date formats

The format field accepts the formats accepted by the php funcion [strftime](https://www.php.net/manual/en/function.strftime.php). The function field allows you to create your own code.

### Currency formats

Currency formats have the following options:

Currency symbol: $, €, EUR, etc.
Prepend symbol: if active the symbol will be prepended ($45.26), else it will be appended (45.26€)
Separate by space: if active, the value and currency symbol will be separated by a space (45.26 €)
Decimals: number of decimals. Set to 0 to disable decimals ($45)
Force decimals: if the value has not decimals, and the decimals settings is not 0, whether to show the decimals or not ($45.00 or $45)
Decimal point: symbol to use as a the decimal point (i.e. $45.26 or $45,26)
Thousands separator: symbol to use as a the thousands separator (i.e. $1,245 or $1.245 or $1 245)

You can also use the function option to create you own code.
