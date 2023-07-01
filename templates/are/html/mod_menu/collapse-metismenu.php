<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('bootstrap.collapse');
?>

<nav id="navbar" class="navbar navbar-expand-lg sticky-top navbar-dark bg-green-dark custom-navbar current-device" aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>">
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
            <?php require __DIR__ . '/dropdown-metismenu.php'; ?>
        </div>
</nav>
