<?php
/**
 * @package DJ-Megamenu
 * @copyright Copyright (C) DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski, Artur Kaczmarek
 *
 */

defined('_JEXEC') or die();
defined('JPATH_BASE') or die;
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldDJMobilebutton extends JFormFieldText {
	
	protected $type = 'DJMobilebutton';
	
	protected function getInput()
	{
		$app = JFactory::getApplication();
		
		$attr = 'readonly="true"';
		$attr.= ' onclick="this.select();"';
		$attr.= ' style="cursor: pointer;"';
		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		
		$moduleid = $app->input->get('id');
		$value = '';
		
		if($moduleid) {
			$value = '<div id="dj-megamenu'.$moduleid.'mobileWrap"></div>';
		} else {
			$attr .= ' placeholder="'.JText::_('MOD_DJMEGAMENU_MOBILE_MENU_WRAPPER_PLACEHOLDER').'"';
		}
				
		$html = '<input type="text" id="' . $this->id . '"' . ' value="'. htmlspecialchars($value, ENT_COMPAT, 'UTF-8') .'" ' . $attr . ' />';
		
		return ($html);
		
	}
}
?>