<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\Domain\Service;

use Doctrine\DBAL\Driver\Exception as ExceptionDbalDriver;
use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;
use In2code\In2frontendauthentication\Utility\ExtensionConfigurationUtility;
use SFC\Staticfilecache\Service\CookieService;
use TYPO3\CMS\Core\Authentication\AuthenticationService as AuthenticationServiceCore;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AuthenticationService
 */
class AuthenticationService extends AuthenticationServiceCore
{
    /**
     * @throws ExceptionDbalDriver
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws \Doctrine\DBAL\Exception
     */
    public function getGroups(array $user, array $knownGroups): array
    {
        /** @var FeGroupsRepository $feGroupsRepository */
        $feGroupsRepository = GeneralUtility::makeInstance(FeGroupsRepository::class);
        $feGroups = $feGroupsRepository->findByCurrentIpAddress();
        if (!empty($feGroups)) {
            $this->setCookie(!empty($feGroups));
            return $feGroups;
        }
        return parent::getGroups($user, $knownGroups);
    }

    /**
     * Set a cookie if staticfilecache is set to disable caching
     *
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     */
    private function setCookie(bool $ipBasedLogin): void
    {
        if (ExtensionManagementUtility::isLoaded('staticfilecache')) {
            /** @var CookieService $cookieService */
            $cookieService = GeneralUtility::makeInstance(CookieService::class);
            $time = time() - 3600;
            if (ExtensionConfigurationUtility::isSfcCookie() && $ipBasedLogin === true) {
                $time = time() + 3600;
            }
            $cookieService->setCookie($time);
        }
    }
}
