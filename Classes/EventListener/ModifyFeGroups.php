<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\EventListener;

use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;
use In2code\In2frontendauthentication\Utility\ExtensionConfigurationUtility;
use SFC\Staticfilecache\Service\CookieService;
use SFC\Staticfilecache\Service\DateTimeService;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent;

class ModifyFeGroups
{
    public function __invoke(ModifyResolvedFrontendGroupsEvent $event): void
    {
        $feGroupsRepository = GeneralUtility::makeInstance(FeGroupsRepository::class);
        $feGroups = $feGroupsRepository->findByCurrentIpAddress();
        if (!empty($feGroups)) {
            $this->setCookie(true);
            $newGroups = array_merge($event->getGroups(), $feGroups);
            $event->setGroups($newGroups);
        }
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
            /** @var DateTimeService $dateTimeService */
            $dateTimeService = GeneralUtility::makeInstance(DateTimeService::class);
            /** @var CookieService $cookieService */
            $cookieService = GeneralUtility::makeInstance(CookieService::class, $dateTimeService);
            $time = time() - 3600;
            if (ExtensionConfigurationUtility::isSfcCookie() && $ipBasedLogin === true) {
                $time = time() + 3600;
            }
            $cookieService->setCookie($time);
        }
    }
}
