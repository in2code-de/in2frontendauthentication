<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\EventListener;

use BeechIt\FalSecuredownload\Events\AddCustomGroupsEvent;
use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;
use In2code\In2frontendauthentication\Utility\ExtensionConfigurationUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent;

class AddCustomGroups
{
    public function __invoke(AddCustomGroupsEvent $event): void
    {
        $feGroupsRepository = GeneralUtility::makeInstance(FeGroupsRepository::class);
        $ipBasedGroups = $feGroupsRepository->findByCurrentIpAddress();

        if (!empty($ipBasedGroups)) {
            foreach ($ipBasedGroups as $feGroup) {
                $newGroups['groups'][$feGroup['uid']] = $feGroup['uid'];
            }
            $event->setCustomUserGroups($newGroups);
        }
    }
}
