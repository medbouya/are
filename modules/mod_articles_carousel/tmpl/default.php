<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_carousel
 *
 * @copyright   (C) 2023 CAP BLANC CONSULTING. <https://capblanc.cloud>
 * @license     CAP BLANC CONSULTING
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

if (!$list) {
    return;
}

?>
<div id="slider" class="">
    <div class="container p-3">
        <div class="card">
            <div class="card-body text-justify">
                <div class="clearfix">
                    <ul class="mod-articlescategory category-module mod-list">
                        <?php if ($grouped) : ?>
                            <?php foreach ($list as $groupName => $items) : ?>
                                <li>
                                    <div class="mod-articles-category-group"><?php echo Text::_($groupName); ?></div>
                                    <ul>
                                        <?php require ModuleHelper::getLayoutPath('mod_articles_carousel', $params->get('layout', 'default') . '_items'); ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php $items = $list; ?>
                            <?php require ModuleHelper::getLayoutPath('mod_articles_carousel', $params->get('layout', 'default') . '_items'); ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>