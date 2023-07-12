<?php
/**
 * @license     GNU General Public License v2.0
 * @version 1.0.0
 * @author Alexander Green
 * @copyright (C) 2022- OSSKit.Net. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die;
//data
$data = $params->get('menuapp');
$data = json_decode($data, true);
if (isset($data)) {
    $additional_data = $data['items'];
    $prm = $data['params'];
    $prm = (object)$prm;
    $selected_menu = $prm->mid;
}else{
    $additional_data = '';
    $prm = '';
    $selected_menu = '';  
}
//---
$subweight = '200px';
$blank = '';
$click_mode = '';
/**
 * override joomla defaul view addin extra options
 */
//use Joomla\CMS\Helper\ModuleHelper;
$id = '';
if ($tagId = $params->get('tag_id', ''))
{
    $id = ' id="' . $tagId . '"';
}
//computed parameter module
// css Override
$drop_width = "'sub_width':'" . $subweight . "', "; //???
$f_size = '';
if ($params->get('f-size') !== 15) {
    $f_size = ' style="font-size:' . $params->get('f-size') .  'px;"';
}
//-----------------------
$id = '';
if ($tagId = $params->get('tag_id', ''))
{
    $id = ' id="' . $tagId . '"';
}
$mobile_wrap_start = '';
$mobile_wrap_end = '';
$mobile_title = '';
$mobile_class = '';
$mobile_but = '';
if ($params->get('mobile_friendly')) {
    $mobile_class = ' omm-mobile-friendly';
    if ($params->get('mobile_friendly_opt') =='omm-mobile-offcanvas') {
        $mobile_but = 'omm-mobile-but';
    } else {
        $mobile_but = 'omm-mobile-but omm-mobile-but-slider';
    }
    if ($params->get('mobile_slider_title')) {
        $mobile_title = ' ' .$module->title;
    }   
    $mobile_wrap_start = '<span class="' . $mobile_but . '"><i class="fas fa-bars"></i>' . $mobile_title . '</span><div class="' . $params->get('mobile_friendly_opt') . '">';
    $mobile_wrap_end = '</div>';
}
//for horizontal only
$float = '';
if (para($prm,'type') =='omm-horizontal') {
    $float = para($prm,'float');//fix it
}
//get mod id
$mId = 'oss-menu-' . $module->id;
//add css
$doc->addStyleDeclaration(ossStyle($prm,$mId) . $params->get('css_ovewride'));
//menu start ---------------------------------------------------------------------
?>
<div class="omm-menu">
<nav id="<?php echo $mId; ?>" class="omm-dir <?php echo para($prm,'type') . $mobile_class;; ?>">
    <?php if (para($prm,'default')): ?>
        <input class="omm-default-image" type="hidden" value="<?php echo para($prm,'default') ?>">        
    <?php endif ?>
<?php echo  $mobile_wrap_start ?>
<div class="omm-hover omm-fade  <?php echo $float ?>">
<ul <?php echo $id; ?> class="omm-mod-menu omm-default-effect <?php echo $class_sfx; ?>">
<?php 
foreach ($list as $i => &$item)
{
// calculated link 
/**
 * extra values from mod param menuapp
 */
$sub = extra($additional_data,$item->id,'subtitle');
$icon = extra($additional_data,$item->id,'icon');
$bg = extra($additional_data,$item->id,'bg');
$icon_color = extra($additional_data,$item->id,'col');
$badge = '';
$tooltip = '';
//icon color
if (!empty($icon_color)) {
    $icon_color = ' style="color:' . $icon_color . '"';
}
//browserNav
$target ='';
if ($item->browserNav) {
    $target =' target="_blank"';
}
//icon
if ($icon) {
     $icon = '<i class="' . $icon . '"' . $icon_color . '></i> ';
}
//subtitle pad if icon
$sub_extra_cls = '';
if (!empty($icon)) {
         $sub_extra_cls = ' omm-sub-pad';
    }
//subtitlee
if (!empty($sub)) {
         $sub= '<p class="omm-desc' . $sub_extra_cls . '">' . $sub . '</p>';
    }
//sub icon - RM SOMETHING
$icon_deeper = '';
$deeper = '';
$level = '';
$ul_level1 = '';
$megaSingle = '';
$megaCol = '';
$megaSub = '';
$img = '';
if ($item->deeper and $item->level =='1'){
   $level = 'top-parent';
   $deeper = ' <i class="fas fa-caret-down"></i>';
}
//-------------
    $itemParams = $item->getParams();
    $class      = 'omm-nav-item item-' . $item->id;
    if ($item->id == $default_id)
    {
        $class .= ' default';
    }
    if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id))
    {
        $class .= ' current';
    }
    if (in_array($item->id, $path))
    {
        $class .= ' active';
    }
    elseif ($item->type === 'alias')
    {
        $aliasToId = $itemParams->get('aliasoptions');
        if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
        {
            $class .= ' active';
        }
        elseif (in_array($aliasToId, $path))
        {
            $class .= ' alias-parent-active';
        }
    }
    if ($item->type === 'separator')
    {
        $class .= ' divider';
    }
    if ($item->deeper)
    {
        $class .= ' omm-parent';
    }
    if ($item->level !==1)
    {
        $class .= ' omm-child';
    }
     if ($item->deeper and $item->level =='2'){
       $class .= ' omm-sub-parent';
    }
    echo '<li class="omm-item ' . $class . $megaSingle . $megaCol .'">';
  // link box TODO Remove span omm-cont
   $link_box_inner = '<span class="omm-cont">' . $img . $icon . '<span>' . $item->title . $deeper. $badge . $sub . '</span></span>';
   $link_start = '<a class="omm-link '. $level . $icon_deeper . '" href="' . $item->link . '"' . $target . $tooltip . '>';
   $link_end = '</a>';
   $span_start = '<span class="omm-link '. $level . $icon_deeper . '"' . $tooltip . '>';
   $span_end = '</span>';
   //removes link of top parent in click mode
   if ($level=='top-parent' && !empty($click_mode)) {
       $link_start = $span_start;
       $link_end = $span_end;
   }
    switch ($item->type) {
        case 'separator';
        case 'heading';
            echo $span_start . $link_box_inner . $span_end;
            break;
        default:
            echo $link_start . $link_box_inner . $link_end;
            break;
    } 
    // overwrited to do it acording setting in module(grouped header) for version PRO
    // The next item is deeper
/*    if ($item->level ==1 && $item->deeper)
    {
        echo '<ul class="omm-sub z-depth-default"></ul>';
    }
    else
    {
        echo '</li>';
    } */
    if ($item->deeper)
    {
        echo '<ul class="omm-sub z-depth-default ok-mm-tree ' . para($prm,'dropStyle') . '">';
    }
    // The next item is shallower.
    elseif ($item->shallower)
    {
        echo '</li>';
        echo str_repeat('</ul></li>', $item->level_diff);
    }
    // The next item is on the same level.
    else
    {
        echo '</li>';
    }
}
?></ul>
</div>
<?php echo  $mobile_wrap_end ?>
</nav>
</div>