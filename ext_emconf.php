<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'in2frontendauthentication',
    'description' => 'Authenticate every visitor as a defined frontend user if IP matches',
    'category' => 'plugin',
    'version' => '8.0.0',
    'state' => 'stable',
    'author' => 'Alex Kellner',
    'author_email' => 'alexander.kellner@in2code.de',
    'author_company' => 'in2code.de',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
