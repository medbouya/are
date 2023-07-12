<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

$columnCount = 0;

?>

<style>
    .list-unstyled li>a {
        font-size: 1rem;
        border-bottom-color: none !important;
        background-color: none !important;
    }
</style>


<ul<?php echo $id; ?> class="navbar-nav mr-auto mt-2 mt-lg-0">
    <?php foreach ($list as $i => &$item) :
        $columnCount++;
        $itemParams = $item->getParams();
        $class = 'nav-item';

        if ($item->id == $default_id) {
            $class .= ' default';
        }

        if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
            $class .= ' active';
        }

        if (in_array($item->id, $path)) {
            $class .= ' active';
        }

        if ($item->deeper) {
            $class .= ' dropdown';
        }

        echo '<li class="' . $class . '">';

        switch ($item->type):
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
                require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                break;
            default:
                require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
                break;
        endswitch;

        if ($item->deeper) {
            echo '<div class="dropdown-menu mega-menu dropdown-menu-lg">';
            echo '<div class="container dropdown-menu-spacing">';
            echo '<div class="row">';
            echo '<div>';
            echo '<ul class="list-unstyled">';
        } elseif ($item->shallower) {
            echo '</li>';

            $diff = ($item->level_diff > 0) ? $item->level_diff : 0;
            echo str_repeat('</ul></div></div></div></div></li>', $diff);
        } else {
            echo '</li>';
        }
    endforeach;
    ?></ul>