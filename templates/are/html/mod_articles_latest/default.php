<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!$list) {
    return;
}

?>

<h1 class="color-gradient-level3 py-3"><?php echo $module->title ?></h1>
<div class="card mb-3">
    <ul class="list-group list-group-flush">
        <?php foreach ($list as $item) : ?>
            <li class="list-group-item">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h5 class="card-title">
                            <?php echo $item->title; ?> &nbsp;
                            <span class="badge bg-blue"><?php echo $item->category_title; ?></span>
                        </h5>
                        <p class="card-text">
                            <i class="introtext"><?php echo substr($item->introtext, 0, 250); ?>...</i>
                        </p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="mt-auto mr-auto">
                        <span class="card-date"><?php echo $item->publish_up; ?></span>
                    </div>
                    <div class="text-right">
                        <a class="btn-read" role="button" href="<?php echo $item->link; ?>" itemprop="url">
                            Lire &nbsp;
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>