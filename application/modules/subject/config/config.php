<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array (
    'name'          => 'Subjects',
    'description'   => 'Manage subject bank, programme subjects and units per semester',
    'author'        => 'Adewale Adegoroye',
    'homepage'      => '<Link to module Name private site>',
    'version'       => '1.0.1',
    'menus'	=> array(
		'academic'	=> 'subject/academic/menu'
	)
);
