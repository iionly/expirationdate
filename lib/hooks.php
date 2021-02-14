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

/**
 * Hook for cron event.
 *
 */
function expirationdate_cron(\Elgg\Hook $hook) {
	$value = expirationdate_expire_entities(false) ? 'Ok' : 'Fail';
	return 'expirationdate: ' . $value;
}
