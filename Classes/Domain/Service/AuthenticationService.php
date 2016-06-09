<?php
namespace In2code\In2frontendauthentication\Domain\Service;

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

use TYPO3\CMS\Sv\AuthenticationService as AuthenticationServiceCore;

/**
 * Class Contact
 */
class AuthenticationService extends AuthenticationServiceCore
{
    public function getUser()
    {
        return parent::getUser();
    }

    public function authUser(array $user)
    {
        return parent::authUser($user);
    }

    public function getGroups($user, $knownGroups)
    {
//        return parent::getGroups($user, $knownGroups);
        $row = (array)$this->getDatabaseConnection()->exec_SELECTgetSingleRow('*', 'fe_groups', 'uid=1');
//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($row, 'in2code: ' . __CLASS__ . ':' . __LINE__);
        return $row;
    }

}
