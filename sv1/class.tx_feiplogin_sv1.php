<?php
/***************************************************************
*  Copyright notice
*  
*  (c) 2010 Bernhard Kraft (kraftb@think-open.at)
*  All rights reserved
* 
*  Based on "cc_iplogin_fe":
*  (c) 2003-2004 René Fritz (r.fritz@colorcube.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is 
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
/** 
 * Service 'Automatic login by IP' for the 'fe_iplogin' extension.
 *
 * @author	Bernhard Kraft <kraftb@think-open.at>
 */


require_once(t3lib_extMgm::extPath('fe_ipauth').'class.tx_feipauth_funcs.php');

class tx_feiplogin_sv1 extends tx_sv_authbase {
	var $ipFuncs = NULL;
	var $rules = array(
		'auto' => 3,
		'onlyAuto' => 4,
	);


	/*
	 * The constructor for this class
	 *
	 * @return void
	 */
	public function tx_feiplogin_sv1() {
		$this->ipFuncs = t3lib_div::makeInstance('tx_feipauth_funcs');
	}
	

	/**
	 * Find a user by IP ('REMOTE_ADDR')
	 *
	 * @return mixed Array of all users matching current IP
	 */
	function getUser() {
		$myIP = $this->ipFuncs->validateIP($this->authInfo['REMOTE_ADDR']);
		$myIP = $this->ipFuncs->toCacheFormat($myIP);

		$autoUsers = array();
		if ($myIP && ($cacheRecords = $this->ipFuncs->getIPcache(-1, 0, $myIP, array(3, 4)))) {
			foreach ($cacheRecords as $cacheEntry) {
				if (intval($cacheEntry['rule_type']) == 3) {
					$user = $cacheEntry['user_id'];
					$autoUsers[$user] = 1;
				}
				if (intval($cacheEntry['rule_type']) == 4) {
					$user = $cacheEntry['user_id'];
					$autoUsers[$user] = 1;
				}
			}
		}
		
		$userPidList = $this->getServiceOption('checkPidList', $this->db_user['checkPidList']);

		$user = false;
		if (count($autoUsers)) {
			$whereParts = array();
			$whereParts[] = 'uid IN ('.implode(',', array_keys($autoUsers)).')';
			if ($userPidList) {
				$whereParts[] = 'pid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($userPidList).')';
			}
			$whereParts[] = '1=1 ' . $this->db_user['enable_clause'];
			$whereStr = implode(' AND ', $whereParts);
			list($user) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', $this->db_user['table'], $whereStr, '', 'uid', 1);
		}
		return $user;
	}
	
	
	/**
	 * Authenticate a user
	 * Return 200 if the IP is right. This means that no more checks are needed. Otherwise authentication may fail because we may don't have a password.
	 *
	 * @param	array 	Data of user.
	 * @return	boolean
	 */	
	function authUser($user)	{
			// if there's no IP-list given then the user is valid, other authentication schemes will take care of it
		$OK = 100;

		$myIP = $this->ipFuncs->validateIP($this->authInfo['REMOTE_ADDR']);
		$myIP = $this->ipFuncs->toCacheFormat($myIP);

		$respectFEipauth = $this->getServiceOption('respectFEipauth', 1);
			// 1 means: login ok, make further checking
			// 200 means: login is fine, no further checking required
		$setValid = $respectFEipauth ? 1 : 200;

		if ($myIP && ($cacheRecords = $this->ipFuncs->getIPcache($user['uid'], 0, $myIP, array(3, 4)))) {
				// If we find a IP cache entry of an auto-login type (3,4) which matches our IP we
				// return a valid code (either 1 to enable further checking or 200 to not take care
				// of other authentication schemes
			$OK = $setValid;
		} elseif ($cacheRecords = $this->ipFuncs->getIPcache($user['uid'], 0, false, array(4))) {
				// This branch will only be active if no auto-login type (3,4) IP cache
				// entry has been found for the current IP. So see if there are any onlyAuto (4)
				// IP cache entries for the current user. So he will only be able to login automatically,
				// but not from the current IP ==> disable further authentication
			$OK = false;
		}
			
		return $OK;
	}	



	/**
	 * fetch groups by ip
	 *
	 * @param	array 	Data of user.
	 * @param	array 	Already known groups
	 * @return	mixed 	groups array
	 */
	function getGroups($user, $knownGroups)	{
		
		$groupDataArr = array();
/*	
		if($this->mode=='getGroupsFE') 	{

			$baseIP = $this->authInfo['REMOTE_ADDR'];
			$searchIP = $baseIP;
			$searchIPstr = $baseIP;
			
			$lockToDomain_SQL = ' AND (lockToDomain="" OR lockToDomain="'.$this->authInfo['HTTP_HOST'].'")';
			if (!$this->authInfo['showHiddenRecords'])	$hiddenP = ' AND NOT hidden';
				
			while (true) {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $this->db_groups['table'], 'NOT deleted '.$hiddenP.
					' AND tx_cciploginfe_auto AND tx_ccipauth_ip_list REGEXP "[^.0-9]*'.addslashes(preg_quote ($searchIPstr)).'"'.$lockToDomain_SQL);	
					
				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))	{
					if(t3lib_div::cmpIP($baseIP, $row['tx_ccipauth_ip_list'])) 	{
						$groupDataArr[$row['uid']]=$row;
					}
				}
				if ($res)	$GLOBALS['TYPO3_DB']->sql_free_result($res);
				
				$parts=explode('.',$searchIP);
				if(count($parts)>1) {
					array_pop($parts);
					$searchIP=implode('.',$parts);
					$searchIPstr=$searchIP.'.';
				} else 	{
					// nothing more to check
					break;
				}
				
			}
			
			
		} elseif ($this->mode=='getGroupsBE') {
			# $this->fetchGroups(...)
			
			# Get the BE groups here
			# needs to be implemented in t3lib_userauthgroup
		}
*/

		return $groupDataArr;
	}
}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/fe_iplogin/sv1/class.tx_feiplogin_sv1.php"]) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/fe_iplogin/sv1/class.tx_feiplogin_sv1.php"]);
}

?>
