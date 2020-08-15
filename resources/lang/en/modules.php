<?php

return [
    'sms' => [
        'smsCenter' => [
            "errors" => [
                'params' => "Wrong parameters.",
                "access" => "Wrong the login or password.",
                "balance" => "Low client's balance.",
                "block" => "The IP address is temporarily blocked because of frequent requests.",
                "format" => "Invalid phone number format.",
                "prohibited" => "The message is prohibited.",
                "invalid" => "Invalid phone number format.",
                "unreached" => "The message cannot be delivered.",
                "limit" => "Sending more than 5 requests for sending or getting a balance during one minute are restricted.",
                "not_exist" => "The message doesn't exist.",
                "processing" => "Processing.",
                "transmitted" => "Transmitted to operator.",
                "expired" => "Expired.",
                "undelivered" => "Undelivered",
                "unavailable" => "Unavailable."
            ]
        ]
    ],
    'repositoryEloquent' => [
        "record_exist" => "The record doesn't exist."
    ],
    "repositoryTreeEloquent" => [
        "node_not_exist" => "The node does not exist."
    ]
];
