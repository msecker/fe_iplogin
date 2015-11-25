<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$_EXTCONF = unserialize($_EXTCONF);
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = isset($_EXTCONF['alwaysAutoLogin']) ? intval($_EXTCONF['alwaysAutoLogin']) : 1;
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['Alto\\FeIplogin\\Service\\LoginService']['checkPidList'] = trim($_EXTCONF['checkPidList']);
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['Alto\\FeIplogin\\Service\\LoginService']['respectFEipauth'] = isset($_EXTCONF['respectFEipauth']) ? intval($_EXTCONF['respectFEipauth']) : 1;

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService($_EXTKEY,  'auth' /* sv type */,  'Alto\\FeIplogin\\Service\\LoginService' /* sv key */,
		array(
				'title' => 'Automatic FE login by IP',
				'description' => 'Login a frontend user automatically if connecting from a configured IP.',

				'subtype' => 'getUserFE,authUserFE',

				'available' => TRUE,
				'priority' => 60,
				'quality' => 50,

				'os' => '',
				'exec' => '',

				'classFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/Service/LoginService.php',
				'className' => 'Alto\FeIplogin\Service\LoginService',
		)
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fe_ipauth']['extraIpListFields']['tx_feiplogin_auto'] = 3;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fe_ipauth']['extraIpListFields']['tx_feiplogin_onlyauto'] = 4;

?>
