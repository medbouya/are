<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.are
 *
 * @copyright   (C) YEAR Your Name
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * This is a heavily stripped down/modified version of the default Cassiopeia template, designed to build new templates off of.
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

// Add Favicon from images folder
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/x-icon']);


// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

//Get params from template styling
//If you want to add your own parameters you may do so in templateDetails.xml
$testparam =  $this->params->get('testparam');

//uncomment to see how this works on site... it just shows 1 or 0 depending on option selected in style config.
//You can use this style to get/set any param according to instructions at https://kevinsguides.com/guides/webdev/joomla4/joomla-4-templates/adding-config
//echo('the value of testparam is: '.$testparam);

// Get this template's path
$templatePath = 'templates/' . $this->template;

//load bootstrap collapse js (required for mobile menu to work)
//this loads collapse.min.js from media/vendor/bootstrap/js - you can check out that folder to see what other bootstrap js files are available if you need them
HTMLHelper::_('bootstrap.collapse');
//dropdown needed for 2nd level menu items
HTMLHelper::_('bootstrap.dropdown');


//Register our web assets (Css)
$wa->useStyle('template.are.bootstrap');
$wa->useStyle('template.are.custom');
$wa->useStyle('template.are.main');
$wa->useStyle('template.are.update');
$wa->useStyle('template.are.user');

//Set viewport
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

?>

<!DOCTYPE html>
<!-- saved from url=(0023) -->
<html lang="fr" dir="ltr">
<!-- Head -->

<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />

    <style>
        .component {
            margin-top: 3rem;
        }
    </style>
</head>
<!-- End Head -->
<!-- Body -->

<body class="<?php echo $pageclass; ?>" id="topPage" data-target="#navbar" data-offset="70">
    <!-- Header -->
    <header>
        <div class="container d-print-none">
            <div class="d-flex pt-1 pb-1">

                <?php if ($this->countModules('top-bar')) : ?>
                    <div class="ml-auto">
                        <jdoc:include type="modules" name="top-bar" style="none" />
                    </div>
                <?php endif; ?>
                <?php if ($this->countModules('language')) : ?>
                    <jdoc:include type="modules" name="language" style="none" />
                <?php endif; ?>
            </div>
        </div>
        <div class="bg-light-grey">
            <div class="container">
                <div class="d-flex pt-2 pb-2">
                    <?php if ($this->countModules('logo')) : ?>
                        <div>
                            <jdoc:include type="modules" name="logo" style="none" />

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header -->
    <!-- Navigation -->
    <?php if ($this->countModules('menu')) : ?>
        <div class="ml-auto">
            <jdoc:include type="modules" name="menu" style="none" />
        </div>
    <?php endif; ?>
    <!-- End navigation -->
    <!-- Carousel -->

    <?php if ($this->countModules('slider')) : ?>
        <jdoc:include type="modules" name="slider" style="none" />
    <?php endif; ?>

    <!-- End carousel -->
    <!-- Content -->
    <div class="component container">
        <div class="row col-10 m-2">
            <jdoc:include type="component" />
        </div>
    </div>
    <div id="news" class="bg-light-grey">
        <div class="container p-3">
            <?php if ($this->countModules('content-top')) : ?>
                <jdoc:include type="modules" name="content-top" style="none" />
            <?php endif; ?>
        </div>
        <!-- End Content -->
        <!-- Footer -->
        <div id="contact" class="">
            <div>
                <div class="text-center d-print-none">
                    <a href="#topPage" title="Haut">
                        <i style="font-size: 4rem !important" class="fas fa-angle-up color-green-dark font-size-3rem opacity-control"></i>
                    </a>
                </div>
                <footer id="foot">
                    <div class="container p-3 d-print-none">
                        <?php if ($this->countModules('footer')) : ?>
                            <jdoc:include type="modules" name="footer" style="none" />
                        <?php endif; ?>

                        <?php if ($this->countModules('social')) : ?>
                            <jdoc:include type="modules" name="social" style="none" />
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md text-center">
                                <label class="copyright">
                                    <?php if ($this->countModules('copyright')) : ?>
                                        <jdoc:include type="modules" name="copyright" style="none" />
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- End footer -->

        <?php
        //Register our web assets (Css)
        $wa->useScript('template.are.jquery');
        $wa->useScript('template.are.popper');
        $wa->useScript('template.are.bs');
        $wa->useScript('template.are.bootstrapjs');
        $wa->useScript('template.are.respond');
        $wa->useScript('template.are.mainjs');
        ?>


        <script>
            $(document).on('click', '.dropdown-menu', function(e) {
                e.stopPropagation();
            });

            $(document).on('click', '#button-search', function() {
                var valeurTerm = $(document).find('#text-search').val();
                var valeurTerm2 = valeurTerm.split(" ");
                var valeurTerm3 = valeurTerm2.join("+");
                window.location.href = '/fr/search/results?query=' + valeurTerm3;
            });

            function searchKeyup(event) {
                if (event.keyCode === 13) {
                    $("#button-search").click();
                }
            }
        </script>

        <script>
            $('form[method="get"]').submit(function() {
                $(this).find(":input").filter(function() {
                    return (!this.value) || (this.value == 0);
                }).attr("disabled", "disabled");
                return true;
            });

            $("form").find(":input").prop("disabled", false);
        </script>

</body>
<!-- End body -->

</html>