<?php

/**
 * Table configuration fe_users
 */
use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$columns = [
    'ip_mask' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:in2frontendauthentication/Resources/Private/Language/locallang_db.xlf:' .
            FeGroupsRepository::TABLE_NAME . '.ip_mask',
        'config' => [
            'type' => 'text',
            'cols' => '40',
            'rows' => '2',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns(FeGroupsRepository::TABLE_NAME, $columns);
ExtensionManagementUtility::addToAllTCAtypes(
    FeGroupsRepository::TABLE_NAME,
    'ip_mask',
    '',
    'after:hidden'
);
