<?php

/**
 * Table configuration fe_users
 */
use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;

$columns = [
    'ip_mask' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:in2frontendauthentication/Resources/Private/Language/locallang_db.xlf:' .
            FeGroupsRepository::TABLE_NAME . '.ip_mask',
        'config' => [
            'type' => 'text',
            'cols' => '40',
            'rows' => '2'
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(FeGroupsRepository::TABLE_NAME, $columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    FeGroupsRepository::TABLE_NAME,
    'ip_mask',
    '',
    'after:hidden'
);
