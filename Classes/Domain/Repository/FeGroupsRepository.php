<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\Domain\Repository;

use Doctrine\DBAL\Driver\Exception;
use In2code\In2frontendauthentication\Utility\DatabaseUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FeGroupsRepository
 */
class FeGroupsRepository
{
    const TABLE_NAME = 'fe_groups';

    /**
     *  Find all fe_groups records with a matching ip_mask definition
     *
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findByCurrentIpAddress(): array
    {
        $allGroups = $this->getAllGroupsWithIpConfiguration();
        return $this->filterGroupsByCurrentIpAddress($allGroups);
    }

    /**
     * @param array $groups [fe_groups.*]
     */
    protected function filterGroupsByCurrentIpAddress(array $groups): array
    {
        foreach ($groups as $key => $group) {
            if ($this->isCurrentIpInList($group['ip_mask']) === false) {
                unset($groups[$key]);
            }
        }
        return $groups;
    }

    protected function isCurrentIpInList(string $ipList): bool
    {
        return GeneralUtility::cmpIP(GeneralUtility::getIndpEnv('REMOTE_ADDR'), $ipList);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function getAllGroupsWithIpConfiguration(): array
    {
        $queryBuilder = DatabaseUtility::getQueryBuilderForTable(self::TABLE_NAME);
        return (array)$queryBuilder
            ->select('*')
            ->from(self::TABLE_NAME)
            ->where('ip_mask != \'\'')
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
