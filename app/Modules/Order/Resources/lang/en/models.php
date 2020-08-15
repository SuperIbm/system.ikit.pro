<?php

return [
    'order' => [
        "school_id" => "ID school",
        "name" => "Name",
        "from" => "From",
        "to" => "To",
        "trial" => "Trial",
        "type" => "Type",
        "orderable_id" => "ID order able",
        "orderable_type" => "Type order able"
    ],
    'orderCharge' => [
        "order_invoice_id" => "ID invoice",
        "charge" => "Charge",
        "status" => "Status"
    ],
    'orderInvoice' => [
        "order_id" => "ID order",
        "order_payment_id" => "ID payment",
        "invoice" => 'Invoice',
        "status" => "Status"
    ],
    'orderPayment' => [
        'name' => 'Name',
        'description' => 'Description',
        'parameters' => 'Parameters',
        'online' => 'Online',
        'system' => 'System',
        'image_id' => 'Image',
        'status' => 'Status'
    ],
    'orderRefund' => [
        "order_charge_id" => "ID payment",
        "refund" => 'Refund',
        "status" => "Status"
    ]
];
