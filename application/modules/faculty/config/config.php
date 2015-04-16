<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array (
    'name'          => 'Faculty',
    'description'   => 'Manage faculty and department with the University',
    'author'        => 'Adewale Adegoroye',
    'homepage'      => '<Link to module Name private site>',
    'version'       => '1.0.1',
    'menus'	=> array(
		'academic'	=> 'faculty/academic/menu'
	)
);
