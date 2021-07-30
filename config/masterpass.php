<?php

return [
    'exportPassword' => '47e3db71-ec0f-4836-8060-ef8083abd3cd',
    'consumerKey' => '927d9436c4e34ae8876a34b7142cc244',
    'certPassword'  => '5a622bb59c',
    'certPath' => '/full/path/to/the/pfx/cert',
    'walletEndpoints' => [
        'v1' => [
            [
                'request' => \Mirazhhi\Masterpass\Request\v1\Login::class,
                'method' => 'login',
            ],
            [
                'request' => \Mirazhhi\Masterpass\Request\v1\GetCards::class,
                'method' => 'getCards',
            ],
        ],
        'v2' => [

        ]
    ]
];
