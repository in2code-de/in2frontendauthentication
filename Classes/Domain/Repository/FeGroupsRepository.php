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

use IPLib\Factory;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Contact
 */
class FeGroupsRepository
{
    const TABLE_NAME = 'fe_groups';

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * FeGroupsRepository constructor.
     */
    public function __construct()
    {
        $this->queryBuilder =
            GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::TABLE_NAME);
    }

    /**
     * Find groups with current IP address
     *
     * @return array
     */
    public function findByCurrentIpAddress()
    {
        $statement = $this->queryBuilder->select('*')
            ->from(self::TABLE_NAME)
            ->where(
                $this->queryBuilder->expr()->eq('deleted', 0),
                $this->queryBuilder->expr()->eq('hidden', 0),
                $this->getIpQueryExpression()
            )
            ->execute();

        if ($statement->rowCount()) {
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
    protected function getIpQueryExpression()
    {
        $currentIpAddresses = $this->getCurrentIpAddresses();
        $orX = $this->queryBuilder->expr()->orX();

        if (!empty($currentIpAddresses)) {
            foreach ($currentIpAddresses as $value) {
                $orX->add($this->queryBuilder->expr()->like('ip_mask', "'%$value%'"));
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
        $ip = GeneralUtility::getIndpEnv('REMOTE_ADDR');
        $address = Factory::addressFromString($ip);

        if ($address->getAddressType() === 4) {
            // ip v4
            $delimiter = '.';
            $useFullIp = false;
        } else {
            // ip v6
            $delimiter = ':';
            $useFullIp = true;
        }

        $wildcards = $this->buildWildcardArray($address->toString($useFullIp), $delimiter);

        // the actual current ip
        $ips = [$ip];

        // it is possible that the user ip address is shortened
        // (e.g. 2001::08d3:1319:8a2e:0370:1334 instead of 2001:0000:0000:08d3:1319:8a2e:0370:1334) so we add also the
        // full ip to the check.
        if ($address->toString(true) !== $ip) {
            $ips[] = $address->toString(true);
        }

        return array_merge($wildcards, $ips);
    }

    /**
     * builds an wildcard array by an given ip e.g.
     *
     *      if the following ip is given: 127.0.0.1
     *
     *      returns:
     *      [
     *            *.*.*.*
     *          127.*.*.*
     *          127.0.*.*
     *          127.0.0.*
     *      ]
     *
     *      if an ip v6 ip is given: 2001:0000:0000:08d3:1319:8a2e:0370:1334
     *
     *      returns:
     *      [
     *          *:*:*:*:*:*:*:*
     *          2001:*:*:*:*:*:*:*
     *          2001.0000*:*:*:*:*:*
     *          ...
     *      ]
     *
     * @param string $ip
     * @param string $delimiter
     * @param string $wildcardChar
     * @return array
     */
    protected function buildWildcardArray($ip, $delimiter, $wildcardChar = '*')
    {
        $parts = GeneralUtility::trimExplode($delimiter, $ip, true);
        $wildcardArray = [];

        for ($key = 0; $key < count($parts); $key++) {
            $wildcardString = '';
            for ($i = 0; $i < count($parts); $i++) {
                if ($i >= $key) {
                    $wildcardString .= $wildcardChar . $delimiter;
                } else {
                    $wildcardString .= $parts[$i] . $delimiter;
                }
            }

            $wildcardArray[] = rtrim($wildcardString, $delimiter);
        }

        return $wildcardArray;
    }
}
