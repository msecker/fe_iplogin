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
	'author' => 'Bernhard Kraft',
	'author_email' => 'kraftb@think-open.at',
	'author_company' => 'think-open',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'fe_ipauth' => '0.0.1-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>
