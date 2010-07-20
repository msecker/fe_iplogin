<?php
if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

$_EXTCONF = unserialize($_EXTCONF);
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = isset($_EXTCONF['alwaysAutoLogin']) ? intval($_EXTCONF['alwaysAutoLogin']) : 1;
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['tx_feiplogin_sv1']['checkPidList'] = trim($_EXTCONF['checkPidList']);
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['tx_feiplogin_sv1']['respectFEipauth'] = isset($_EXTCONF['respectFEipauth']) ? intval($_EXTCONF['respectFEipauth']) : 1;

t3lib_extMgm::addService($_EXTKEY,  'auth' /* sv type */,  'tx_feiplogin_sv1' /* sv key */,
	array(
		'title' => 'Automatic FE login by IP',
		'description' => 'Login a frontend user automatically if connecting from a configured IP.',

		'subtype' => 'getUserFE,authUserFE,getGroupsFE',

		'available' => TRUE,
		'priority' => 60,
		'quality' => 50,

		'os' => '',
		'exec' => '',

		'classFile' => t3lib_extMgm::extPath($_EXTKEY).'sv1/class.tx_feiplogin_sv1.php',
		'className' => 'tx_feiplogin_sv1',
	)
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fe_ipauth']['extraIpListFields']['tx_feiplogin_auto'] = 3;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fe_ipauth']['extraIpListFields']['tx_feiplogin_onlyauto'] = 4;

?>
