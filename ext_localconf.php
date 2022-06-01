<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    /**
     * Register service for frontend authentication
     */
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
});
