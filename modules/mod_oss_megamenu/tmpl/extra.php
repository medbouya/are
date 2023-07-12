<?php
/**
 * @license     GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
jimport( 'joomla.application.module.helper' );
$h = '';
$c = '';
$s = '';
if(para($prm,'topHeight') !=40){
    $h = 'height:' . para($prm,'topHeight') . 'px;';
}
if(!empty(para($prm,'extraColors'))){
    $h = 'color:' . para($prm,'extraColors');
}
if(!empty($h) or !empty($c)){
    $s = ' style="' . $h . $c . '"';
}
?>

<div class="omm-extra-icons"<?php echo $s ?>>
    <?php if (!empty($search)): ?>
         <span class="os-modal-click" data-os-modal="#omm-modal-search">
            <i class="fas fa-search"></i>
        </span>       
    <?php endif ?>
    <?php if (!empty($mode_1) and count(JModuleHelper::getModules('nvmod'))): ?>
        <span class="os-modal-click" data-os-modal="#omm-modal-m1">
            <i class="<?php echo para($prm,'mod_1_icon') ?>"></i>      
        </span>     
    <?php endif ?>
</div>
<div class="os-modal-bg"></div>
<?php if (!empty($search)): ?>
<div id="omm-modal-search" class="os-modal-content os-modal-content-600 os-modal-search">
    <i class="fas fa-times os-modal-close"></i>
    <?php 
        $module = JModuleHelper::getModule('mod_finder');
        echo JModuleHelper::renderModule($module, array('style' => ''));
     ?>
</div>
<?php endif ?>
<?php if (!empty($mode_1) and count(JModuleHelper::getModules('nvmod'))): ?>
 <div id="omm-modal-m1" class="os-modal-content os-modal-content-600">
    <i class="fas fa-times os-modal-close"></i>
    <jdoc:include type="modules" name="nvmod" style=""/>
</div>   
<?php endif ?>




