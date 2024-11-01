<?php

return [
	'plugin' => [
		'name' => 'Expirationdate',
		'version' => '5.0.0',
	],
	'settings' => [
		'period' => 'fiveminute',
	],
	'events' => [
		'cron' => [
			'all' => [
				"\ExpirationdateEvents::expirationdate_cron" => [],
			],
		],
	],
];
