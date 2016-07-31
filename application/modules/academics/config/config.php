<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array (
    'name'          => 'Academics',
    'description'   => 'Setup and manage academic session, semesters, faculties and departments within the University/College',
    'author'        => 'Adewale Adegoroye',
    'homepage'      => '<Link to module Name private site>',
    'version'       => '1.0.1',
    'menus'	=> array(
		'settings'	=> 'academics/settings/menu'
	)
);
