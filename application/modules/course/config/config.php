<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array (
    'name'          => 'Course',
    'description'   => 'Managing everything about degree, course bank and Study programme',
    'author'        => 'Adewale Adegoroye',
    'homepage'      => '<Link to module Name private site>',
    'version'       => '1.0.1',
    'menus'	=> array(
		'academic'	=> 'course/academic/menu',
		'settings'	=> 'course/settings/menu'
	),
);
