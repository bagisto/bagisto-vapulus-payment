<?php

return [
    [
        'key'    => 'sales.paymentmethods.vapulus',
        'name'   => 'vapulus::app.admin.system.vapulus',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'active',
                'title'         => 'vapulus::app.admin.system.status',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],  [
                'name'          => 'title',
                'title'         => 'vapulus::app.admin.system.title',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'vapulus::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' => true,
                'locale_based'  => true,
            ],  [
                'name'          => 'website_id',
                'title'         => 'vapulus::app.admin.system.website-id',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
            ],  [
                'name'          => 'app_id',
                'title'         => 'vapulus::app.admin.system.app-id',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
            ],  [
                'name'          => 'secure_hash',
                'title'         => 'vapulus::app.admin.system.secure-hash',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
            ],  [
                'name'          => 'password',
                'title'         => 'vapulus::app.admin.system.password',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
            ],  [
                'name'          => 'currency_code',
                'title'         => 'vapulus::app.admin.system.currency',
                'type'          => 'select',
                'repository'    => 'Webkul\Vapulus\Helpers\Helper@getCurrencies',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'    => 'sort',
                'title'   => 'vapulus::app.admin.system.sort_order',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1
                    ], [
                        'title' => '2',
                        'value' => 2
                    ], [
                        'title' => '3',
                        'value' => 3
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ], [
                        'title' => '5',
                        'value' => 5,
                    ]
                ],
                'channel_based' => true,
                'locale_based'  => false,
            ]
        ]
    ]
];