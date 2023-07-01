<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_carousel
 *
 * @copyright   (C) 2023 CAP BLANC CONSULTING. <https://capblanc.cloud>
 * @license     CAP BLANC CONSULTING
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

?>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php $count = 0; ?>
    <?php foreach ($items as $item) : ?>
        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $count ?>" <?php if ($count == 0) { echo 'class="active"'; } ?>></li>
        <?php $count++; ?>
    <?php endforeach; ?>
  </ol>
  <div class="carousel-inner">
    <?php $count = 0; ?>
    <?php foreach ($items as $item) : ?>
        <?php $images = json_decode($item->images);
            $introImageUrl = $images->image_intro;
        ?>
        <div class="carousel-item <?php if ($count == 0) { echo 'active'; } ?>">
            <img class="d-block w-100" src="<?php echo $introImageUrl ?>" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5 class="slider-title"><?php echo $item->title; ?></h5>
                <p class="slider-description"><?php echo strip_tags($item->introtext); ?></p>
            </div>
        </div>
        <?php $count++; ?>
    <?php endforeach; ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
            