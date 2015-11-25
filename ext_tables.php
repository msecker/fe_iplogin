<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$tempColumns = array(
	'tx_feiplogin_auto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/Resources/Private/Language/locallang_db.xlf:fe_users.tx_feiplogin_auto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
	'tx_feiplogin_onlyauto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/Resources/Private/Language/locallang_db.xlf:fe_users.tx_feiplogin_onlyauto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_feiplogin_auto, tx_feiplogin_onlyauto');


$tempColumns = array(
	'tx_feiplogin_auto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/Resources/Private/Language/locallang_db.xlf:fe_groups.tx_feiplogin_auto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
	'tx_feiplogin_onlyauto' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fe_iplogin/Resources/Private/Language/locallang_db.xlf:fe_groups.tx_feiplogin_onlyauto',
		'config' => array(
			'type' => 'input',
			'size' => '30',
		)
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_groups', $tempColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_groups', 'tx_feiplogin_auto, tx_feiplogin_onlyauto');

?>
