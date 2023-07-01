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
    </head>
    <!-- End Head -->
    <!-- Body -->
    <body class="<?php echo $pageclass; ?>" id="topPage" data-spy="scroll" data-target="#navbar" data-offset="70">
        <!-- Header -->
        <header>
            <div class="container d-print-none">
                <div class="d-flex pt-1 pb-1">
                    
                    <?php if ($this->countModules('top-bar')) : ?>
                        <div class="ml-auto">
                            <jdoc:include type="modules" name="top-bar" style="none" />
                        </div>
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
        <nav id="navbar" class="navbar navbar-expand-lg sticky-top navbar-dark bg-green-dark custom-navbar current-device">
            <div class="container collapse navbar-collapse" id="navbarNav">
                <div class="ml-auto d-lg-none">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item"><a href="#" onclick="return false;" id="popover-mobile" class="nav-link nav-icon cursor-pointer" tabindex="0" data-placement="bottom" data-toggle="popover" data-trigger="click" title="" data-animation="true" data-content="&lt;div class=&#39;input-group&#39;&gt;&lt;input type=&#39;text&#39; id=&#39;text-search&#39; class=&#39;form-control form-control-sm&#39; placeholder=&#39;Mots clés ...&#39; aria-label=&#39;...&#39; aria-describedby=&#39;button-search&#39; onkeyup=&#39;searchKeyup(event)&#39;&gt;&lt;div class=&#39;input-group-append&#39;&gt;&lt;button class=&#39;btn btn-custom-red btn-sm&#39; type=&#39;button&#39; id=&#39;button-search&#39;&gt;Chercher&lt;/button&gt;&lt;/div&gt;&lt;/div&gt;" data-html="true" data-template="&lt;div id=&quot;searchDiv&quot; class=&quot;popover&quot; role=&quot;tooltip&quot;&gt;&lt;div class=&quot;arrow&quot;&gt;&lt;/div&gt;&lt;div class=&quot;popover-body p-2&quot;&gt;&lt;/div&gt;&lt;/div&gt;" data-original-title="Recherche"><i class="fas fa-search"></i><span class="sr-only">Recherche</span></a></li>
                    </ul>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbarToggler" aria-controls="mainNavbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbarToggler">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="navbar-home" href="index.html" title="Accueil"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="nav-item">
                            <a id="dropdown-about" class="nav-link " href="#">L'Autorité</a>
                        </li>    
                        <li class="nav-item">
                            <a id="dropdown-about" class="nav-link " href="#">Télécommunications</a>
                        </li>    
                        <li class="nav-item">
                            <a id="dropdown-about" class="nav-link " href="#">Poste</a>
                        </li>    
                        <li class="nav-item"><a class="nav-link nav-link-level1 " href="#">Eau</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Electricité
                            </a>
                            <div class="dropdown-menu mega-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                                <div class="container dropdown-menu-spacing">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5 class="text-uppercase">Catégorie 1</h5>
                                            <ul class="list-unstyled">
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 1.1</a></li>
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 1.2</a></li>
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 1.3</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="text-uppercase">Catégorie 2</h5>
                                            <ul class="list-unstyled">
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 2.1</a></li>
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 2.2</a></li>
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 2.3</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="text-uppercase">Catégorie 3</h5>
                                            <ul class="list-unstyled">
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 3.1</a></li>
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 3.2</a></li>
                                            <li><a class="dropdown-item" href="#">Sous-catégorie 3.3</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link nav-link-level1 " href="#">Contact</a></li>
                    </ul>
                    <div class="ml-auto d-none d-lg-block">
                        <ul class="navbar-nav my-2 my-lg-0">
                            <li class="nav-item">
                            <li class="nav-item"><a href="#fr" onclick="return false;" id="popover-desktop" class="nav-link nav-icon cursor-pointer" tabindex="0" data-placement="bottom" data-toggle="popover" data-trigger="click" title="" data-animation="true" data-content="&lt;div class=&#39;input-group&#39;&gt;&lt;input type=&#39;text&#39; id=&#39;text-search&#39; class=&#39;form-control form-control-sm&#39; placeholder=&#39;Mots clés ...&#39; aria-label=&#39;...&#39; aria-describedby=&#39;button-search&#39; onkeyup=&#39;searchKeyup(event)&#39;&gt;&lt;div class=&#39;input-group-append&#39;&gt;&lt;button class=&#39;btn btn-custom-red btn-sm&#39; type=&#39;button&#39; id=&#39;button-search&#39;&gt;Chercher&lt;/button&gt;&lt;/div&gt;&lt;/div&gt;" data-html="true" data-template="&lt;div id=&quot;searchDiv&quot; class=&quot;popover&quot; role=&quot;tooltip&quot;&gt;&lt;div class=&quot;arrow&quot;&gt;&lt;/div&gt;&lt;div class=&quot;popover-body p-2&quot;&gt;&lt;/div&gt;&lt;/div&gt;" data-original-title="Recherche"><i class="fas fa-search"></i><span class="sr-only">Recherche</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- End navigation -->
        <!-- Carousel -->
        <div id="slider" class="">
            <div class="container p-3">
                <div class="card">
                    <div class="card-body text-justify">
                        <div class="clearfix">
                            <?php if ($this->countModules('slider')) : ?>
                                <jdoc:include type="modules" name="slider" style="none" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End carousel -->
        <!-- Content -->
        <div id="news" class="bg-light-grey">
            <div class="container p-3">
                <h1 class="color-gradient-level3 py-3">Actualités</h1>
                <div class="card mb-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title">
                                    Appel à candidature&nbsp;
                                    <span class="badge bg-blue">Avis de Recrutement</span>
                                </h5>
                                <p class="card-text card-text-custom card-text-custom-list">
                                    L’Autorité de Régulation de la Poste et des Communications Electroniques (ARPCE) lance un
                                    appel à candidature pour la nomination du Directeur des Finances et de la Comptabilité. 
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mt-auto mr-auto">
                                <span class="card-date">03 avril 2023 12:42</span>
                            </div>
                            <div class="text-right">
                                <a class="btn-read see" role="button" href="#">Lire</a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title">
                                    Décret exécutif n° 23-123 du 25 Chaâbane 1444 correspondant au 18 mars 2023&nbsp;
                                    <span class="badge bg-gradient-level2">Décret Exécutif</span>
                                </h5>
                                <p class="card-text card-text-custom card-text-custom-list">
                                    Modifiant et complétant le décret exécutif n° 21-44 du 3 Joumada Ethania 1442 correspondant au 17 janvier 2021 fixant le régime d'exploitation
                                    applicable à chaque type de réseaux ouverts au
                                    public et aux différents services de communications
                                    électroniques.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mt-auto mr-auto">
                                <span class="card-date">30 mars 2023 13:35</span>
                            </div>
                            <div class="text-right">
                                <a class="btn-read see" role="button" href="#">Lire</a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title">
                                    Avis de retrait définitif de certificat d’enregistrement&nbsp;
                                    <span class="badge bg-blue">Communiqué</span>
                                </h5>
                                <p class="card-text card-text-custom card-text-custom-list">
                                    L’Autorité de régulation informe du retrait définitif du certificat d’enregistrement pour l’exploitation des services postaux relevant du régime de la simple déclaration (régime intérieur), délivré à l’opérateur listé ci-après, pour non-respect des dispositions législatives et réglementaires, et invite ce dernier à se rapprocher, sans délais, des services de l’Autorité de régulation.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mt-auto mr-auto">
                                <span class="card-date">13 mars 2023 17:35</span>
                            </div>
                            <div class="text-right">
                                <a class="btn-read see" role="button" href="#">Lire</a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title">
                                    Décret présidentiel du 23 Joumada Ethania 1444 correspondant au 16 janvier 2023&nbsp;
                                    <span class="badge bg-gradient-level1">Décret Présidentiel</span>
                                </h5>
                                <p class="card-text card-text-custom card-text-custom-list">
                                    Portant 
                                    nomination du président du Conseil de l'Autorité
                                    de régulation de la poste et des communications
                                    électroniques.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mt-auto mr-auto">
                                <span class="card-date">19 février 2023 12:37</span>
                            </div>
                            <div class="text-right">
                                <a class="btn-read see" role="button" href="#">Lire</a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="card-title">
                                    Décret présidentiel du 23 Moharram 1444 correspondant
                                    au 21 août 2022&nbsp;
                                    <span class="badge bg-gradient-level1">Décret Présidentiel</span>
                                </h5>
                                <p class="card-text card-text-custom card-text-custom-list">
                                    Portant nomination du directeur
                                    général de l’Autorité de régulation de la poste et des
                                    communications électroniques.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mt-auto mr-auto">
                                <span class="card-date">19 février 2023 12:04</span>
                            </div>
                            <div class="text-right">
                                <a class="btn-read see" role="button" href="#">Lire</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Content -->
        <!-- Footer -->
        <div id="contact" class="">
            <div>
                <div class="text-center d-print-none">
                    <a href="#topPage" title="Haut">
                        <i class="fa-solid fa-angle-up color-green-dark font-size-3rem opacity-control"></i>
                    </a>
                </div>
                <footer id="foot">
                    <div class="container p-3 d-print-none">
                        <div class="row pb-4">
            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                
                            </div>

                            <div class="col-md-4">
                                <div class="footer-contact">
                                    <h3>Contacts</h3>
                                    <table class="table">
                                        <tr>
                                            <td>Adresse</td>
                                            <td>Rue Abou Beker Bin Amer</td>
                                        </tr>
                                        <tr>
                                            <td>B. P.</td>
                                            <td>4908</td>
                                        </tr>
                                        <tr>
                                            <td>Téléphone</td>
                                            <td>00 222 45 29 12 70</td>
                                        </tr>
                                        <tr>
                                            <td>Faxe</td>
                                            <td>00 222 45 29 12 70</td>
                                        </tr>
                                        <tr>
                                            <td>E-mail</td>
                                            <td>contact@are.mr</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-4">
                                
                            </div>
                        </div>

                        <div class="row p-4">
                            <div class="col-md text-center">
                                <a rel="nofollow" href="#" target="_blank" title="" data-toggle="tooltip" data-placement="bottom" aria-label="Suivez nous sur Facebook" data-original-title="Suivez nous sur Facebook"><i class="fab fa-facebook-f btn-social facebook p-1"></i><span class="sr-only">Suivez nous sur Facebook</span></a>
                                <a href="r#" onclick="return false;" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Prochainement"><i class="fab fa-twitter btn-social"></i><span class="sr-only">Suivez nous sur Twitter</span></a>
                                <a rel="nofollow" href="#" target="_blank" title="" data-toggle="tooltip" data-placement="bottom" aria-label="Suivez nous sur LinkedIn" data-original-title="Suivez nous sur LinkedIn"><i class="fab fa-linkedin-in btn-social linkedin p-1"></i><span class="sr-only">Suivez nous sur LinkedIn</span></a>
                                <a rel="nofollow" href="#" target="_blank" title="" data-toggle="tooltip" data-placement="bottom" aria-label="Suivez nous sur Youtube" data-original-title="Suivez nous sur Youtube"><i class="fab fa-youtube btn-social youtube p-1"></i><span class="sr-only">Suivez nous sur Youtube</span></a>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md text-center">
                                <label class="copyright">Copyright © 2023 ARE - Tous droits réservés</label>
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
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });

            $(document).on('click', '#button-search', function () {
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

            $('form[method="get"]').submit(function () {
                $(this).find(":input").filter(function () { return (!this.value) || (this.value==0); }).attr("disabled", "disabled");          
                return true;
            });

            $("form").find(":input").prop("disabled", false);

        </script>

    </body>
    <!-- End body -->
</html>