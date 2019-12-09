<?php
namespace In2code\In2frontendauthentication\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Alex Kellner <alexander.kellner@in2code.de>, in2code.de
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Contact
 */
class FeGroupsRepository
{
    const TABLE_NAME = 'fe_groups';

    /**
     * Find groups with current IP address
     *
     * @return array
     */
    public function findByCurrentIpAddress()
    {
        /**
         * @var $queryBuilder \TYPO3\CMS\Core\Database\Query\QueryBuilder
         */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::TABLE_NAME);

        /**
         * @var $statement \Doctrine\DBAL\Driver\Mysqli\MysqliStatement
         */
        $statement = $queryBuilder->select('*')
            ->from(self::TABLE_NAME)
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0),
                $this->getIpQueryExpression($queryBuilder)
            )
            ->execute();

        if($statement->rowCount()) {
            return $statement->fetchAll();
        }

        return [];
    }

    /**
     * Build expression like
     *      ip_mask like "%1.1.1.1%" and ip_mask like "%2.2.2.2%"
     *
     * @return CompositeExpression
     */
    protected function getIpQueryExpression($queryBuilder)
    {
        $currentIpAdresses = $this->getCurrentIpAddresses();
        if (!empty($currentIpAdresses)) {
            $orX = $queryBuilder->expr()->orX();
            foreach ($currentIpAdresses as $value) {
                $orX->add($queryBuilder->expr()->like('ip_mask', "'%$value%'"));
            }
        }

        return $orX;
    }

    /**
     * Get current IP address and all variants with wildcards
     *
     * @return array
     */
    protected function getCurrentIpAddresses()
    {
        $ips = [
            GeneralUtility::getIndpEnv('REMOTE_ADDR')
        ];
        $parts = GeneralUtility::trimExplode('.', $ips[0], true);
        $ips[] = '*.*.*.*';
        $ips[] = $parts[0] . '.*.*.*';
        $ips[] = $parts[0] . '.' . $parts[1] . '.*.*';
        $ips[] = $parts[0] . '.' . $parts[1] . '.' . $parts[2] . '.*';
        return $ips;
    }

    /**
     * @return DatabaseConnection
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
