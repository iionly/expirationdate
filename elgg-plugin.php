<?php

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/hooks.php');

return [
	'bootstrap' => \ExpirationdateBootstrap::class,
	'settings' => [
		'period' => 'fiveminute',
	],
];
