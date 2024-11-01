<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'name' => 'Expirationdate',
		'version' => '4.0.0',
	],
	'settings' => [
		'period' => 'fiveminute',
	],
	'hooks' => [
		'cron' => [
			'all' => [
				"\ExpirationdateHooks::expirationdate_cron" => [],
			],
		],
	],
];
