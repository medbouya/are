<?php
/**
* @license   GNU General Public License v2.0
* @version 1.0.0
* @author Alexander Green
* @copyright (C) 2022- OSSKit.Net. All rights reserved.
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/
defined('_JEXEC') or die;
?>
<!-- dev -->
<!-- <br> val 1 - {{params.dropType}}
<br> val 2 - {{params.groupBy}}
<br> -->
<span class="omi-but-app" v-if="!params.edit_mode" v-on:click="switchMode()"><i class="fas fa-edit"></i> Edit Mode</span>
<span class="omi-but-app" v-if="params.edit_mode" v-on:click="switchMode()"><i class="fas fa-eye"></i> Preview Mode</span>
<span v-on:click="megaR()" data-tooltip="<?php echo JText::_('MOD_OSS_H_REFRESH') ?>" data-flow="right"><i class="fas fa-sync"></i></span>
<div v-if="params.menu" class="omm-dir omm-admin omi-container" :class="params.type" :style="size()">
  <div :class="[params.float, dropEffectClass()]" :style="{background: params.topBg}">
    <nav>
      <div class="omi-admin-click" :class="">
        <ul v-if="params.mid!==0" class="omm-mod-menu" :class="[params.float, params.hover]">
          <!-- li & link starts ---------------- -->
          <li class="omm-item" :data-parent="el.parent" :data-omm-id="el.id"  :data-img="el.img" :class="[el.clsP, el.clsCh, el.drop, groupHeader(index)]" v-for="(el, index) in items" :key="index"> 
            <!-- column image -->
              <div v-if="params.dropType=='omm-columns-image' && el.clsCh && el.clsHeader" class="omm-column-img" :style="columnImg(index)"></div>
              <!-- el - {{el.menuActive}} -->
            <div class="omm-link" :data-omm="el.id" :style="itemStyle()" :data-tooltip="el.tooltip" :data-flow="params.tooltipPos" @click="editEl(index)">
              <span class="omm-cont" :style="linkS(index)"> 
                <i v-if="el.icon" :class="el.icon" :style="{color: el.col}"></i>
                <span>{{el.title}} <i v-if="el.clsP=='omm-parent'" class="parent-icon fas fa-caret-down"></i>
                  <img v-if="el.badge" :src="el.badge">
                  <p v-if="el.subtitle" class="omm-descr" :style="subS(index)">{{el.subtitle}}</p>
                </span>
              </span>
            </div>
            <!-- submenu -->
            <ul v-if="el.clsP=='omm-parent' && el.clsCh!=='omm-child'" :id="el.id" class="omm-sub" :class="[params.shadow, params.dropType, params.dropStyle, params.groupBy]" :data-columns="el.colQun" :data-width="params.subWidth" :style="dropS()">
              <!-- preview column ----------- -->
              <div v-if="params.dropType=='omm-columns-preview'" class="omm-preview-box" :style="defImg(index)"></div> 
            </ul>
          </li>
          <!-- item form ---------- -->
          <aside v-if="el.edit" v-for="(el, index) in items" class="omm-edit">
            <span class="omm-close" @click="el.edit=0"><i class="fas fa-times"></i></span>
            <h3><i :class="el.icon" :style="{color: el.col}"></i> {{el.title}}</h3>
            <template v-if="el.clsP && params.dropType!=='ok-mm-tree' && params.groupBy=='oms-auto'">
            <label><?php echo JText::_('MOD_OSS_COL_AMOUNT') ?></label>
            <select class="osi-trigger" v-model="el.colQun" @change="megaR()">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
            </template>
            <template v-if="params.dropType!=='ok-mm-tree' && params.groupBy!=='oms-default'">
            <div v-if="el.clsCh" class="omi-header-check">
              <input type="checkbox" value="omm-group-header" v-model="el.clsHeader" class="osi-trigger-check" @change="megaR()">
              <label data-osstt="<?php echo JText::_('MOD_OSS_SET_HEADER_TT') ?>"><?php echo JText::_('MOD_OSS_SET_HEADER') ?></label>
            </div>
            </template>
            <div class="omm-icon-group">
              <div class="omm-icon-select" @click="el.iconList='1'"><?php echo JText::_('MOD_OSS_SELECTICON') ?></div>
              <div v-show="el.iconList==1" class="oi-icon-list-wrap-heading oi-icons-hidden">
                <input class="oi-icon-filter" type="text" v-model="keyword" placeholder="Search Icon..." />
              <i class="fas fa-times" @click="el.iconList='0'"></i></div>
              <div class="oki_filter-count"></div>
              <div v-show="el.iconList==1" class="oi-icon-list-wrap oi-icons-hidden">
                <label v-for="icon in filteredList"><input type="radio" :value="icon.ic" v-model="el.icon"><i :class="icon.ic"></i>{{icon.ic}}</label>
              </div>
            </div>
            <label><?php echo JText::_('MOD_OSS_ICON_COLOR') ?></label>
            <div class="osi-colorpicker" :style="{background: el.col}"><colorpicker :color="el.col" v-model="el.col"/></div>
            <label><?php echo JText::_('MOD_OSS_DESC') ?></label>
            <textarea cols="30" rows="3" v-model="el.subtitle"></textarea>
            <template v-if="params.dropType=='omm-columns-preview' || params.dropType=='omm-columns-grouped-preview'">
            <template v-if="el.clsP || el.clsCh">
            <label><?php echo JText::_('MOD_OSS_IMG') ?></label>
            <div class="os-media-manager">
              <div v-if="el.img" class="os-media-preview"><img :src="el.img" alt=""><i class="fas fa-times-circle" v-on:click="mediaRemove(index)"></i></div>
              <input type="text" v-model="el.img">
              <div class="omi-select-img os-media-manager-select" v-on:click="mediaLoad(index)">Select Image</div>
              <template v-if="el.imgInput">
              <div class="os-image-select-buttons"><span class="os-img-select" v-on:click="mediaIn(index)">Select</span> <span class="os-img-cancel" v-on:click="mediaCansel(index)">Cancel</span> <p></p></div>
              </template>
            </div>
            </template>
            </template>
            <label><?php echo JText::_('MOD_OSS_TOOLTIP') ?><span class="om-pro-note">Premium</span></label>
            <input type="text" v-model="el.tooltip">
            <label><?php echo JText::_('MOD_OSS_BADGE') ?><span class="om-pro-note">Premium</span></label>
            <div class="omi-badges">
              <?php
              /*
              render badges from a directory
              */
              $dir = JPATH_ROOT . '/modules/mod_oss_megamenu/assets/images/badges';
              $arr = glob($dir . "/*.png");
              //radio buttons
              echo '<label><input type="radio" value="" v-model="el.badge"><span>None</span></label>';
              foreach ($arr as $value) {
              $f_name = str_replace($dir ."/", "", $value);
              $f_name = str_replace(".png", "", $f_name);
              $file_url = JURI::root() . '/modules/mod_oss_megamenu/assets/images/badges/' . $f_name . '.png';
              echo '<label><input type="radio" value="' . $file_url . '" v-model="el.badge"><span><img src="' . $file_url . '">' . $f_name . '</span></label>';
              }
              ?>
            </div>
          </aside>
          <?php
          //EXTRA ELEMENTS AND HELP MODALS
          include 'extras.php';
          ?>
        </ul>
      </div>
    </nav>
  </div>
</div>
<div class="omi-mega-note-medium" v-if="params.edit_mode && params.msg_edit">
<i class="fas fa-info-circle"></i> <?php echo JText::_('MOD_OSS_N_EDIT') ?>
<span data-tooltip="Don't show again" data-flow="left" v-on:click="params.msg_edit=!params.msg_edit"><i class="fas fa-times"></i></span>
</div>
<div v-if="params.msg_info" class="omi-mega-note-main">
<?php echo JText::_('MOD_OSS_N0') ?>
<span data-tooltip="Don't show again" data-flow="left" v-on:click="params.msg_info=!params.msg_info">
<i lass="fas fa-times"></i></span>
</div>
<!-- menu setting form ---------------------- -->
<div class="omm-filter-trigger"></div>
<i class="far fa-square omi-reload" @click="params.menu=!params.menu" style="display: none;"></i>
<?php include 'sidebar.php'; ?>
<div class="os-media"><iframe src="index.php?option=com_media&view=media&tmpl=component&mediatype&path=local-images:/" frameborder="0"></iframe></div>