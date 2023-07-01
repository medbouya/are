<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Utilities\ArrayHelper;

/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseScript('metismenu', 'media/templates/site/cassiopeia/js/mod_menu/menu-metismenu.min.js', [], ['defer' => true], ['metismenujs']);

$attributes          = [];
$attributes['class'] = 'navbar-nav mr-auto mt-2 mt-lg-0 ' . $class_sfx;

if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = $tagId;
}

$start = (int) $params->get('startLevel', 1);

?>
<ul <?php echo ArrayHelper::toString($attributes); ?>>
<?php foreach ($list as $i => &$item) {
    // Skip sub-menu items if they are set to be hidden in the module's options
    if (!$showAll && $item->level > $start) {
        continue;
    }

    $itemParams = $item->getParams();
    $class      = [];
    $class[]    = 'nav-item item-' . $item->id . ' level-' . ($item->level - $start + 1);

    if ($item->id == $default_id) {
        $class[] = 'default';
    }

    if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
        $class[] = 'current';
    }

    if (in_array($item->id, $path)) {
        $class[] = 'active';
    } elseif ($item->type === 'alias') {
        $aliasToId = $itemParams->get('aliasoptions');

        if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
            $class[] = 'active';
        } elseif (in_array($aliasToId, $path)) {
            $class[] = 'alias-parent-active';
        }
    }

    if ($item->type === 'separator') {
        $class[] = 'divider';
    }

    if ($showAll) {
        if ($item->deeper) {
            $class[] = 'deeper';
        }

        if ($item->parent) {
            $class[] = 'parent';
        }
    }

    echo '<li class="' . implode(' ', $class) . '">';

    switch ($item->type) :
        case 'separator':
        case 'component':
        case 'heading':
        case 'url':
            require ModuleHelper::getLayoutPath('mod_menu', 'dropdown-metismenu_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'dropdown-metismenu_url');
    endswitch;

    switch (true) :
        // The next item is deeper.
        case $showAll && $item->deeper:
            echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown' . $item->id . '" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo $item->title;
        echo '</a>';

        // Only display the <li> element for the top-level item.
        if ($item->level === $start + 1) {
            echo '</li>';
        }

        // Fetch and display the submenu items
        $submenu = $item->getChildren();
        if (!empty($submenu)) {
            echo '<div class="dropdown-menu mega-menu dropdown-menu-lg" aria-labelledby="navbarDropdown' . $item->id . '">';
            echo '<div class="container dropdown-menu-spacing">';
            echo '<div class="row">';

            // Loop through the submenu items and display them
            foreach ($submenu as $subitem) {
                echo '<div class="col-md-4">';
                echo '<h5 class="text-uppercase">' . $subitem->title . '</h5>';
                echo '<ul class="list-unstyled" level="' . ($item->level + 1) . '">';

                // Fetch and display the sub-submenu items
                $subsubmenu = $subitem->getChildren();
                if (!empty($subsubmenu)) {
                    foreach ($subsubmenu as $subsubitem) {
                        echo '<li><a class="dropdown-item" href="' . $subsubitem->link . '">' . $subsubitem->title . '</a></li>';
                    }
                }

                echo '</ul>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</li>';
            break;

        // The next item is shallower.
        case $item->shallower:
            echo '</li>';
            echo str_repeat('</ul></li>', $item->level_diff);
            break;

        // The next item is on the same level.
        default:
            echo '</li>';
            break;
    endswitch;

}
?></ul>
