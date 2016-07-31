<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array (
    'name'          => 'Applications',
    'description'   => 'Manage Admission Applications such as result, acceptance, clearance and convert to student',
    'author'        => 'Adewale Adegoroye',
    'homepage'      => '<Link to module Name private site>',
    'version'       => '1.0.1',
    'menus'	=> array(
		'contents'	=> 'acceptance/contents/menu'
	)
);
