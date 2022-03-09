<?php
declare(strict_types=1);
namespace In2code\In2frontendauthentication\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtensionConfigurationUtility
{
    /**
     * @param $path
     * @param string $extensionKey
     * @return string
     */
    public static function getExtensionConfiguration($path, $extensionKey = 'in2frontendauthentication'): string
    {
        return (string)GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)
            ->get($extensionKey, $path);
    }

    /**
     * @return bool
     */
    public static function isSfcCookie(): bool
    {
        return (bool)self::getExtensionConfiguration('set_sfc_cookie');
    }
}
