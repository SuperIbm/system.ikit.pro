<?php

return [
    'blockIp' => [
        'ip' => 'IP mask',
        'status' => 'Status'
    ],
    'user' => [
        'image_small_id' => 'Small image',
        'image_middle_id' => 'Middle image',
        'login' => 'Login',
        'password' => 'Password',
        'remember_token' => 'Token',
        'first_name' => 'Firstname',
        'second_name' => 'Secondname',
        'telephone' => 'Telephone',
        'two_factor' => 'Двухфакторная аутентификация',
        'status' => 'Status'
    ],
    'userAddress' => [
        "user_id" => 'ID user',
        'postal_code' => 'Postal code',
        'country' => 'Country code',
        'region' => 'Region code',
        'city' => 'City',
        'street_address' => 'Street address',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude'
    ],
    'userAuth' => [
        'user_id' => 'ID user',
        'os' => 'OS',
        'device' => 'Device',
        'browser' => 'Browser',
        'agent' => 'Agent',
        'ip' => 'IP',
        'latitude' => 'latitude',
        'longitude' => 'longitude'
    ],
    'userRecovery' => [
        'user_id' => 'ID user',
        'code' => 'Code'
    ],
    'userReferral' => [
        'referral_id' => "ID referral",
        'user_invited_id' => "ID invited user",
        'user_inviting_id' => "ID inviting user"
    ],
    'userRole' => [
        'name' => 'Name role',
        'description' => 'Description',
        'status' => 'Status'
    ],
    'userSchool' => [
        'user_id' => "ID user",
        'school_id' => "ID school",
        'status' => 'Status'
    ],
    'userSchoolRole' => [
        'user_id' => "ID user",
        'school_role_id' => "ID role of school"
    ],
    'userVerification' => [
        'user_id' => 'ID user',
        'code' => 'Code',
        'status' => 'Status'
    ],
    'userWallet' => [
        'user_id' => "ID user",
        'amount' => "Amount",
        'currency' => "Currency"
    ],
    'userWalletInput' => [
        'user_wallet_id' => 'ID user wallet',
        'amount' => 'Amount'
    ],
    'userWalletOutput' => [
        'user_wallet_id' => 'ID user wallet',
        'order_charge_id' => 'ID order charge',
        'amount' => 'Amount'
    ]
];
