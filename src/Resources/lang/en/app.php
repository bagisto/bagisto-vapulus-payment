<?php

return [
    'admin'     => [
        'system'    => [
            'vapulus'       => 'Vapulus Payment Gateway',
            'status'        => 'Status',
            'title'         => 'Title',
            'description'   => 'Description',
            'website-id'    => 'Website Id',
            'app-id'        => 'App Id',
            'secure-hash'   => 'App Secure Hash',
            'password'      => 'App Password',
            'currency'      => 'Vapulus Currency',
            'sort_order'    => 'Sort Order',
        ],

        'layouts'   => [
            'vapulus-transactions'  => 'Vapulus Transactions',
        ],

        'sales' => [
            'transactions'  => [
                'title'                     => 'Vapulus Transaction History',
                'view-title'                => 'Transaction Id: #:transaction_id',
                'response-info'             => 'Response Info',
                'transaction-info'          => 'Transaction Info',
                'status-code'               => 'Response Code',
                'message'                   => 'Response Message',
                'amount'                    => 'Amount',
                'status'                    => 'Response Status',
                'transaction-type'          => 'Transaction Type',
                'service-id'                => 'ServiceId',
                'service-type'              => 'Service Type',
                'account-type'              => 'Account Type',
                'destination-type'          => 'Destination Type',
                'production'                => 'Production Mode',
                'mobile-number'             => 'Mobile Number',
                'error-config-missing'      => 'Provide the Vapulus config Secure-Hash, App Id, and Password fields values.',
                'transaction-id'            => 'Transaction Id',
                'order-id'                  => 'Order Id',
                'error-missing-transaction' => 'Transaction detail is missing.',
            ]
        ]
    ],
    
    'shop'  => [
        'checkout'  => [
            'page-title'                => 'Bagisto Vapulus Payment',
            'error-website-id'          => 'Warning: You have to provide vapulus\'s website id.',
            'error-payment-cancel'      => ' Vapulus payment has been canceled.',
            'error-transaction-failed'  => 'Warning: Vapulus transaction faild.',
            'error-cart-empty'          => ' Shopping cart is empty.',
            'error-transaction-fraud'   => 'Warning: Vapulus found a fraud transaction.',
            'payment'                   => [
                'page-title'            => 'Vapulus Payment',
            ],
        ]
    ]
];  