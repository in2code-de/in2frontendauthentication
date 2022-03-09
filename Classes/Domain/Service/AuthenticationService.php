<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\Domain\Service;

use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;
use In2code\In2frontendauthentication\Utility\ExtensionConfigurationUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Authentication\AuthenticationService as AuthenticationServiceCore;

/**
 * Class AuthenticationService
 */
class AuthenticationService extends AuthenticationServiceCore
{
    /**
     * This method is called in fronted and should bypass the authentication for content elements and pages
     *
     * @param array $user
     * @param array $knownGroups
     * @return array
     */
    public function getGroups(array $user, array $knownGroups): array
    {
        $feGroupsRepository = ObjectUtility::getObjectManager()->get(FeGroupsRepository::class);
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
     * @param bool $ipBasedLogin
     */
    private function setCookie(bool $ipBasedLogin): void
    {
        if (ExtensionManagementUtility::isLoaded('staticfilecache')) {
            $cookieService = GeneralUtility::makeInstance(
                \SFC\Staticfilecache\Service\CookieService::class
            );
            $time = time() - 3600;
            if (ExtensionConfigurationUtility::isSfcCookie() && $ipBasedLogin === true) {
                $time = time() + 3600;
            }
            $cookieService->setCookie($time);
        }
    }
}
