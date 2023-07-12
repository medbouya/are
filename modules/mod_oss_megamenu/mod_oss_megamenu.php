<?php
/**
 * @license		GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
$doc = JFactory::getDocument();
// Include assets
// $doc->addStyleSheet(JURI::root()."modules/mod_oss_megamenu/01-css-dev/style.css");//dev
$doc->addStyleSheet(JURI::root()."modules/mod_oss_megamenu/assets/css/style.css");
//load font awsome
if (!empty($params->get('fontawesome'))) {
	// $doc->addStyleSheet("https://use.fontawesome.com/releases/v5.15.4/css/all.css");//cdn
	$doc->addStyleSheet("modules/mod_oss_megamenu/assets/css/all.min.css");//hostyouself
}
//load jquery
if (!empty($params->get('jquery'))) {
	$doc->addScript(JURI::root()."modules/mod_oss_megamenu/assets/js/jquery-3.6.1.min.js");
}
$doc->addScript(JURI::root()."modules/mod_oss_megamenu/assets/js/script.js");
require_once 'helper.php';
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\Menu\Site\Helper\MenuHelper;
$list       = MenuHelper::getList($params);
// $list       = MenuHelper::getList('');
$base       = MenuHelper::getBase($params);
$active     = MenuHelper::getActive($params);
$default    = MenuHelper::getDefault();
$active_id  = $active->id;
$default_id = $default->id;
$path       = $base->tree;
$showAll    = $params->get('showAllChildren', 1);
$class_sfx  = htmlspecialchars($params->get('class_sfx', ''), ENT_COMPAT, 'UTF-8');
if (count($list))
{
	require JModuleHelper::getLayoutPath('mod_oss_megamenu', $params->get('layout', 'default'));
}