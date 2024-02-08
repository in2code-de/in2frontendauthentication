<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\Utility;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtensionConfigurationUtility
{
    /**
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     */
    public static function getExtensionConfiguration(
        string $path,
        string $extensionKey = 'in2frontendauthentication'
    ): string {
        return (string)GeneralUtility::makeInstance(ExtensionConfiguration::class)->get($extensionKey, $path);
    }

    /**
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     */
    public static function isSfcCookie(): bool
    {
        return (bool)self::getExtensionConfiguration('set_sfc_cookie');
    }
}
