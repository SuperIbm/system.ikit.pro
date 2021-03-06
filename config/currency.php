<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Драйвер получения котировок по умолчанию
    |--------------------------------------------------------------------------
    |
    | Определяем систему получения котировок по умолчанию. cbr - система получания
    | курсов валют с Центрального Банка России
    |
    */

    'driver' => env('CURRENCY', 'cbr'),
    'item' => env('CURRENCY_ITEM', 'RUB'),
];
