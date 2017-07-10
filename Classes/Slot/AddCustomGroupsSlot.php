<?php
namespace In2code\In2frontendauthentication\Slot;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use In2code\In2frontendauthentication\Domain\Repository\FeGroupsRepository;

class AddCustomGroupsSlot
{

    public function addCustomGroups($checkPermissions)
    {
        $feGroupsRepository = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(FeGroupsRepository::class);
        $feGroups = $feGroupsRepository->findByCurrentIpAddress();



        $customGroups = [];
        foreach ($feGroups as $feGroup) {
            $customGroups[] = $feGroup['uid'];
        }

        $checkPermissions->addCustomGroups($customGroups);
    }
}
