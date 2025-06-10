<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),
    'characters' => '23456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    'default' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'type' => 'alphanumeric',
    ],
    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
        'type' => 'flat',
    ],
     //..........
     'CAPTCHA_TYPE' => env('MATH_ENABLE', 0),
];
