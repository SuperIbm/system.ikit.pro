<?php

return [
    'middleware' => [
        'allowGuest' => [
            'text' => 'Access to this part of the application forbidden, you have to log out.',
            'label' => 'Authorized.'
        ],
        'allowLimit' => [
            'text' => 'Access to this part of the application is not allowed.',
            'label' => 'Limited.'
        ],
        'allowOAuth' => [
            'label' => 'Unauthorized.',
            'no_header' => 'Unauthorized: No header.'
        ],
        'allowPaid' => [
            'message' => [
                'true' => 'Access to this part of the application is not allowed because of the unpaid plan.',
                'false' => 'Access to this part of the application is not allowed because of the paid plan.'
            ],
            'label' => [
                'true' => 'Unpaid.',
                'false' => 'Paid.'
            ]
        ],
        'allowRole' => [
            'message' => 'Access to this part of the application has been ended, please log in again.',
            'label' => 'Unauthorized.'
        ],
        'allowSchool' => [
            'message' => 'Access to this part of the application is not allowed.',
            'label' => 'Restricted.'
        ],
        'allowSection' => [
            'message' => 'Access to this part of the application is not allowed.',
            'label' => 'Restricted.'
        ],
        'allowTrial' => [
            'message' => [
                'true' => 'Access to this part of the application only for the trial version.',
                'false' => 'Access to this part of the application is not allowed for the trial version.'
            ],
            'label' => [
                'true' => 'Paid.',
                'false' => 'Trial.'
            ]
        ],
        'allowUser' => [
            'message' => 'Access to this part of the application has been ended, please log in again.',
            'label' => 'Unauthorized.'
        ],
        'allowVerified' => [
            'message' => [
                'true' => 'Access to this part of the application only for a verified user.',
                'false' => 'Access to this part of the application only for an unverified user.'
            ],
            'label' => [
                'true' => 'Unverified.',
                'false' => 'Verified.'
            ]
        ]
    ],
    'requests' => [
        'accessApiClientRequest' => [
            'login' => 'Login',
            'password' => 'Password'
        ],
        'accessApiRefreshRequest' => [
            'refreshToken' => 'Refresh token'
        ],
        'accessApiTokenRequest' => [
            'secret' => 'Secret key'
        ],
        'accessForgetRequest' => [
            'login' => 'Login'
        ],
        'accessPasswordRequest' => [
            'password_current' => 'Current password',
            'password' => 'Password'
        ],
        'accessResetCheckRequest' => [
            'code' => 'Code'
        ],
        'accessResetRequest' => [
            'code' => 'Code',
            'password' => 'Password'
        ],
        'accessSignInRequest' => [
            'login' => 'Login',
            'password' => 'Password',
            'remember' => 'Remember'
        ],
        'accessSignUpRequest' => [
            'login' => 'Login',
            'password' => 'Password',
            'first_name' => 'First name',
            'second_name' => 'Last name',
            'company' => 'Company',
            'telephone' => 'Telephone'
        ],
        'accessSocialRequest' => [
            'id' => 'ID',
            'type' => 'Type',
            'login' => 'Login'
        ],
        'accessVerifiedRequest' => [
            'code' => 'Code'
        ]
    ],
    'controllers' => [
        'accessController' => [
            'social' => [
                'log' => 'Log in with social network.'
            ],
            'signIn' => [
                'log' => 'User signed in.'
            ],
            'signUp' => [
                'log' => 'A new user signed up.'
            ],
            'verified' => [
                'log' => 'A new user signed up.'
            ],
            'verify' => [
                'log' => 'The email for the user verification was sent.'
            ],
            'forget' => [
                'log' => 'The email for recovery the password was sent.'
            ],
            'update' => [
                'log' => 'Update the user.'
            ],
            'password' => [
                'log' => 'Password was changed by user.'
            ],
        ]
    ]
];
