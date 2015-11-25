<?php

########################################################################
# Extension Manager/Repository config file for ext "fe_iplogin".
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Auth: Automatic FE login by IP',
	'description' => 'Login a frontend user automatically if connecting from a configured IP.',
	'category' => 'services',
	'shy' => 0,
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'fe_users,fe_groups',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Matthias Secker',
	'author_email' => 'secker@alto.de',
	'author_company' => 'alto.de New Media GmbH',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.2.0',
	'constraints' => array(
		'depends' => array(
			'fe_ipauth' => '0.2.0-0.0.0',
			'typo3' => '6.2-7.6',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>
