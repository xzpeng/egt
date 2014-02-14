<?php
/**
 * @version   $Id: Wordpress.php 11888 2013-07-01 17:47:02Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokSprocket_Provider_Simple_Storage_Wordpress extends RokSprocket_Provider_Simple_Storage_Abstract
{


	/**
	 *
	 * @param $module_id
	 *
	 * @throws RokSprocket_Exception
	 * @return RokSprocket_ItemCollection
	 */
	protected function getItemsFromDB($module_id)
	{
		global $wpdb;
		$query = 'SELECT i.provider_id as id, i.order, i.params';
		$query .= ' FROM #__roksprocket_items as i';
		$query .= ' WHERE i.widget_id = "' . $module_id . '"';
		$query .= ' AND i.provider = "' . RokSprocket_Provider_Simple_Storage_Interface::PROVIDER_NAME . '"';
		$query          = str_replace('#__', $wpdb->prefix, $query); //add wp db prefix
		$sprocket_items = $wpdb->get_results($query, OBJECT_K);
		if ($sprocket_items === false) {
			throw new RokSprocket_Exception($wpdb->last_error);
		}

		$converted = $this->convertRawToItems($sprocket_items);
		$this->mapPerItemData($converted, $module_id);
		return $converted;
	}

	/**
	 * @param RokSprocket_ItemCollection $items
	 *
	 * @param                            $module_id
	 *
	 * @throws RokSprocket_Exception
	 */
	protected function mapPerItemData(RokSprocket_ItemCollection &$items, $module_id)
	{
		global $wpdb;
		$query = 'SELECT i.provider_id as id, i.order, i.params';
		$query .= ' FROM #__roksprocket_items as i';
		$query .= ' WHERE i.widget_id = "' . $module_id . '"';
		$query .= ' AND i.provider = "' . RokSprocket_Provider_Simple_Storage_Interface::PROVIDER_NAME . '"';
		$query          = str_replace('#__', $wpdb->prefix, $query); //add wp db prefix
		$sprocket_items = $wpdb->get_results($query, OBJECT_K);
		if ($sprocket_items === false) {
			throw new RokSprocket_Exception($wpdb->last_error);
		}

		/** @var $items RokSprocket_Item[] */
		foreach ($items as $item_id => &$item) {
			list($provider, $id) = explode('-', $item_id);
			if (array_key_exists($id, $sprocket_items)) {
				$items[$item_id]->setOrder((int)$sprocket_items[$id]->order);
				if (!is_null($sprocket_items[$id]->params)) {
					$items[$item_id]->setParams(RokCommon_Utils_ArrayHelper::fromObject(RokCommon_JSON::decode($sprocket_items[$id]->params)));
				} else {
					$items[$item_id]->setParams(array());

				}
			}
		}
	}

	protected function isAdmin()
	{
		return is_admin();
	}
}
