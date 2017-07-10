<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'in2frontendauthentication',
    'auth',
    \In2code\In2frontendauthentication\Domain\Service\AuthenticationService::class,
    [
        'title' => 'Frontenduser authentication service',
        'description' => 'Authentication visitors as frontend users if IP address is matching.',
        'subtype' => 'getUserFE,authUserFE,getGroupsFE',
        'available' => true,
        'priority' => 50,
        'quality' => 50,
        'os' => '',
        'exec' => '',
        'className' => \In2code\In2frontendauthentication\Domain\Service\AuthenticationService::class,
    ]
);

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher->connect(
    \BeechIt\FalSecuredownload\Security\CheckPermissions::class,
    'AddCustomGroups',
    \In2code\In2frontendauthentication\Slot\AddCustomGroupsSlot::class,
    'addCustomGroups'
);


