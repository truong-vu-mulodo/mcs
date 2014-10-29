<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
	
		
	// ########## API routing config ##########

	// Routes "POST /{version}/users" to "{version}/user/create"
	'(:version)/users'   => array(
								array('POST', new Route('$1/user/create'))
							),
	
);