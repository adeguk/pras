<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array (
    'name'          => 'Student Manager',
    'description'   => 'Managing everything about various student and their course registration',
    'author'        => 'Adewale Adegoroye',
    'homepage'      => '<Link to module Name private site>',
    'version'       => '1.0.1',
    'menus'	=> array(
		'academic'	=> 'student_manager/academic/menu',
		#'content'	=> 'student_manager/content/menu',
		'reports'	=> 'student_manager/reports/menu'
	),
);
