<?php
/**
 * Expiration Date
 *
 * @package ExpirationDate
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Brett Profitt 2008
 * @link http://eschoolconsultants.com
 *
 * (c) iionly 2012 for Elgg 1.8 onwards
 */

class ExpirationdateEvents {
	/**
	* Hook for cron event.
	*
	*/
	public static function expirationdate_cron(\Elgg\Event $event) {
		$period = $event->getType();

		if ($period !== elgg_get_plugin_setting('period', 'expirationdate')) {
			return;
		}

		$value = \ExpirationdateFunctions::expirationdate_expire_entities(false) ? 'Ok' : 'Fail';
		return 'expirationdate: ' . $value;
	}
}
