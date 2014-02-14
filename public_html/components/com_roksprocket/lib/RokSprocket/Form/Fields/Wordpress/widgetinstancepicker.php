<?php
/**
 * @version   $Id: widgetinstancepicker.php 10887 2013-05-30 06:31:57Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokCommon_Form_Field_WidgetInstancePicker extends RokCommon_Form_Field_List
{
	protected static $widgets;

	protected $type = 'WidgetInstancePicker';

	public function getInput()
	{
		$html = parent::getInput();
		ob_start();?>
    <a id="rs-post-url" href="<?php echo get_bloginfo('url');?>/wp-admin/admin.php?page=roksprocket-edit&id=_WIDGET_ID_" style="">Configure
        Widget</a>
    <a id="rs-new-post-url" href="<?php echo get_bloginfo('url');?>/wp-admin/admin.php?page=roksprocket-edit" style="">Add
        a New Widget</a>
	<?php
		$html .= ob_get_clean();
		return $html;
	}


	/**
	 * Method to get the field options for the list of installed editors.
	 *
	 * @return  array  The field option objects.
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$container = RokCommon_Service::getContainer();
		/** @var $model RokSprocket_Model_Widgets */
		$model   = $container->getService('roksprocket.widgets.model');
		$widgets = $model->getAvailableInstances();

		$fieldname = $this->element['name'];
		$options   = array();
		$options[] = RokCommon_HTML_SelectList::option('', rc__('- Select RockSprocket Widget -'));
		foreach ($widgets as $info) {
			if ($this->value == $info['id']) $selected = ' selected="selected"'; else $selected = "";
			$tmp       = RokCommon_HTML_SelectList::option($info['id'], $info['title']);
			$options[] = $tmp;
		}
		$options = array_merge(parent::getOptions(), $options);
		foreach ($options as &$option) {
			// Set some option attributes.
			$option->attr = array(
				'class'=> $option->value,
				'rel'  => $fieldname . '_' . $option->value
			);
		}
		reset($options);
		return $options;
	}
}
