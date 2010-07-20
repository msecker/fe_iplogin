<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$tempColumns = array(
	'tx_feiplogin_auto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/locallang_db.php:fe_users.tx_feiplogin_auto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
	'tx_feiplogin_onlyauto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/locallang_db.php:fe_users.tx_feiplogin_onlyauto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('fe_users', 'tx_feiplogin_auto, tx_feiplogin_onlyauto');


$tempColumns = array(
	'tx_feiplogin_auto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/locallang_db.php:fe_groups.tx_feiplogin_auto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
	'tx_feiplogin_onlyauto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/locallang_db.php:fe_groups.tx_feiplogin_onlyauto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
);

t3lib_div::loadTCA('fe_groups');
t3lib_extMgm::addTCAcolumns('fe_groups', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('fe_groups', 'tx_feiplogin_auto, tx_feiplogin_onlyauto');

?>
