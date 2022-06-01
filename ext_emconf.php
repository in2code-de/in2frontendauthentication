<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'in2frontendauthentication',
    'description' => 'Authenticate every visitor as a defined frontend user if IP matches',
    'category' => 'plugin',
    'shy' => 0,
    'version' => '6.0.0',
    'dependencies' => 'cms,extbase,fluid',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 1,
    'lockType' => '',
    'author' => 'Alex Kellner',
    'author_email' => 'alexander.kellner@in2code.de',
    'author_company' => 'in2code.de',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    '_md5_values_when_last_written' => '',
];
