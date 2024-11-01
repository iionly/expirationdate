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

class ExpirationdateFunctions {

	/**
	* Deletes expired entities.
	* @return boolean
	*/
	public static function expirationdate_expire_entities($verbose=true) {

		$returnvalue = elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function() use($verbose) {
			$now = time();

			$entities = elgg_get_entities([
				'metadata_name' => 'expirationdate',
				'limit' => false,
				'batch' => true,
				'batch_inc_offset' => false,
			]);

			if (!$entities) {
				// no entities that need to expire.
				return true;
			}

			foreach ($entities as $entity) {
				if ($entity->expirationdate < $now) {
					$guid = $entity->guid;
					if (!elgg_trigger_event_result('expirationdate:expire_entity', $entity->type, ['entity' => $entity], true)) {
						continue;
					}

					// call the standard delete to allow for triggers, etc.
					if ($entity->expirationdate_disable_only == 1) {
						if ($entity->disable()) {
							$return = self::expirationdate_unset($entity->getGUID());
							$msg = "Disabled $guid<br>\n";
						} else {
							$msg = "Couldn't disable $guid<br>\n";
						}
					} else {
						if ($entity->delete()) {
							$msg = "Deleted $guid<br>\n";
						} else {
							$msg = "Couldn't delete $guid<br>\n";
						}
					}
				} else {
					if (!elgg_trigger_event_result('expirationdate:will_expire_entity', $entity->type, ['expirationdate' => $entity->expirationdate, 'entity' => $entity], true)) {
						continue;
					}
				}

				if ($verbose) {
					print $msg;
				}
			}
			return true;
		});

		return $returnvalue;
	}

	/**
	* Sets an expiration for a GUID/Id.
	*
	* @param int $id
	* @param strToTime style date $expiration
	* @return bool
	*/
	public static function expirationdate_set($id, $expiration, $disable_only=false, $type='entities') {

		$returnvalue = elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function() use($id, $expiration, $disable_only, $type) {
			if (!($date = strtotime($expiration))) {
				return false;
			}

			// clear out any existing expiration
			self::expirationdate_unset($id, $type);
			$return = false;

			if ($type == 'entities') {
				// @todo what about disabled entities?
				// Allow them to expire?
				$entity = get_entity($id);
				if (!$entity) {
					return false;
				}
				$return = $entity->setMetadata('expirationdate', $date, 'integer');
				$return = $entity->setMetadata('expirationdate_disable_only', (int) $disable_only, 'integer');
			} else {
				// bugger all.
			}

			return $return;
		});

		return $returnvalue;
	}

	/**
	* Removes an expiration date for an entry.
	*
	* @param $guid
	* @param $type
	* @return unknown_type
	*/
	public static function expirationdate_unset($id, $type='entities') {

		elgg_call(ELGG_IGNORE_ACCESS | ELGG_SHOW_DISABLED_ENTITIES, function() use($id, $type) {
			if ($type == 'entities') {
				elgg_delete_metadata([
					'guid' => $id,
					'metadata_name' => 'expirationdate',
				]);
				elgg_delete_metadata([
					'guid' => $id,
					'metadata_name' => 'expirationdate_disable_only',
				]);
			}
		});

		return true;
	}
}
