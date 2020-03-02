<?php
declare(strict_types=1);
namespace In2code\In2frontendauthentication\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ExtensionConfigurationUtility
{
    /**
     * @param $path
     * @param string $extensionKey
     * @return array
     */
    public static function getExtensionConfiguration($path, $extensionKey = 'in2frontendauthentication'): array
    {
        $version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionStringToArray(
            VersionNumberUtility::getCurrentTypo3Version()
        );

        // TYPO3 9 and above
        if ($version['version_main'] >= 9) {
            $value = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)
                ->get($extensionKey, $path);
        } else {
            // TYPO3 8 and below
            $extConfiguration = GeneralUtility::makeInstance(ObjectManager::class)
                ->get(\TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility::class)
                ->getCurrentConfiguration($extensionKey);

            $value = $extConfiguration[$path]['value'];
        }

        return $value;
    }

    /**
     * @return bool
     */
    public static function isSfcCookie(): bool
    {
        return (bool)self::getExtensionConfiguration('set_sfc_cookie');
    }
}
