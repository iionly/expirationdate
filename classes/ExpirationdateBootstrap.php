<?php

use Elgg\DefaultPluginBootstrap;

class ExpirationdateBootstrap extends DefaultPluginBootstrap {

	public function init() {
		elgg_register_plugin_hook_handler('cron', elgg_get_plugin_setting('period', 'expirationdate'), 'expirationdate_cron');
	}
}
