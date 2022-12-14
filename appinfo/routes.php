<?php
declare(strict_types=1);

return [
	'routes' => [
		// App Root
		[
			'name' => 'page#index',
			'url' => '/',
			'verb' => 'GET'
		],
		// Internal views
		[
			'name' => 'page#views',
			'url' => '/{view}',
			'verb' => 'GET',
			'requirements' => array('view' => '.+')
		],
	],
];
