<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\EventListener;

use BeechIt\FalSecuredownload\Events\AddCustomGroupsEvent;
use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
