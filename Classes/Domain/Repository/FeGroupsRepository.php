<?php

declare(strict_types=1);

namespace In2code\In2frontendauthentication\Domain\Repository;

use Doctrine\DBAL\Driver\Exception;
use In2code\In2frontendauthentication\Exception\ClassDoesNotExistException;
use In2code\In2frontendauthentication\Utility\DatabaseUtility;
use IPTools\IP;
use IPTools\Range;
use Throwable;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FeGroupsRepository
 */
class FeGroupsRepository
{
    const TABLE_NAME = 'fe_groups';

    /**
     * FeGroupsRepository constructor.
     * @throws ClassDoesNotExistException
     */
    public function __construct()
    {
        if (class_exists(Range::class) === false) {
            throw new ClassDoesNotExistException(
                'IPTools/Range is not available. Did you install this extension via composer?',
                1583143391
            );
        }
    }

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
        $ips = GeneralUtility::trimExplode(',', $ipList, true);
        foreach ($ips as $ip) {
            if ($this->isCurrentIpAddressInRangeDefinition(GeneralUtility::getIndpEnv('REMOTE_ADDR'), $ip) === true) {
                return true;
            }
        }
        return false;
    }

    protected function isCurrentIpAddressInRangeDefinition(string $ip, string $ipRange): bool
    {
        try {
            return Range::parse($ipRange)->contains(new IP($ip));
        } catch (Throwable $exception) {
            return false;
        }
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
            ->where('ip_mask != ""')
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
