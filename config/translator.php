<?php

use AnimalTranslator\Api\Languages\Languages;

return [
    'languages' => [
        Languages::HUMAN ,
        Languages::LABRADOR,
        Languages::POODLE ,
        Languages::PARRAKEET,
    ],

    'translationTargets' => [
        Languages::HUMAN     => [
            Languages::LABRADOR,
            Languages::POODLE ,
            Languages::PARRAKEET,
            Languages::PARROT,
        ],
        Languages::LABRADOR  => [
            Languages::POODLE ,
            Languages::PARROT,
        ],
        Languages::POODLE  => [
            Languages::LABRADOR,
            Languages::PARROT,
        ],
        Languages::PARRAKEET  => [
            Languages::PARROT,
        ],
    ]
];