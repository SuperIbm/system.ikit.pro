<?php

return [
    'order' => [
        "school_id" => "ID школы",
        "name" => "Название",
        "from" => "От",
        "to" => "До",
        "trial" => "Пробная версия",
        "type" => "Тип",
        "orderable_id" => "ID модели заказа",
        "orderable_type" => "Тип модели заказа"
    ],
    'orderCharge' => [
        "order_invoice_id" => "ID счета",
        "charge" => "Оплата",
        "status" => "Статус"
    ],
    'orderInvoice' => [
        "order_id" => "ID заказа",
        "invoice" => 'Выставленный счет',
        "status" => "Статус"
    ],
    'orderPayment' => [
        'name' => 'Название',
        'description' => 'Описание',
        'parameters' => 'Параметры',
        'online' => 'Онлайн',
        'system' => 'Система',
        'image_id' => 'Изображение',
        'status' => 'Статус'
    ],
    'orderRefund' => [
        "order_charge_id" => "ID оплаты",
        "refund" => 'Возврат',
        "status" => "Статус"
    ]
];
