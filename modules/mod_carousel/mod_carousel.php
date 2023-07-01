<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

// Check if the module is found
$module = ModuleHelper::getModule($module->id);
if ($module && $module->isLoaded()) {

    // Load the params as an array
    $paramsArray = $module->params->toArray();

    // Create a JRegistry object from the array
    $params = new JRegistry($paramsArray);

    // Set the default value for the category parameter
    $params->set('category', 1, 'The category ID');

    // Get a specific parameter value
    $category = $params->get('category');

    // Get the latest articles from the selected category
    $db = Factory::getDbo();
    $query = $db->getQuery(true)
        ->select('a.id, a.title, a.alias')
        ->from('#__content AS a')
        ->innerJoin('#__categories AS c ON a.catid = c.id')
        ->where('a.state = 1')
        ->where('c.id = ' . $category)
        ->order('a.publish_up DESC')
        ->setLimit(5);
    $db->setQuery($query);
    $articles = $db->loadObjectList();

    // Render the module output
    require JModuleHelper::getLayoutPath('mod_carousel');
}


?>
